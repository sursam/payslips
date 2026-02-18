static seedMenuData = catchAsyncErrors(async (req, res, next) => {
    const projectRoot = path.resolve(__dirname, '../../');
    const seedFilePath = `${projectRoot}/seeders/data/menuData.json`;
    const rawData = fs.readFileSync(seedFilePath);
    const menuData = JSON.parse(rawData);
    const seedingCode = this.createRandomString(5) + '-' + Date.now();

    if (menuData.groups && menuData.groups.length) {
        // 1. Map to an array of promises and WAIT for them all
        await Promise.all(menuData.groups.map(async (menuGroupData) => {
            let menuGroupSlug = slugify(menuGroupData.name);
            
            try {
                // 2. Await the group upsert
                const groupData = await super.upsert(menuGroupModel, { 
                    uuid: crypto.randomUUID(), 
                    name: menuGroupData.name, 
                    slug: menuGroupSlug, 
                    order: menuGroupData.order, 
                    created_at: new Date(), 
                    updated_at: new Date() 
                }, { slug: menuGroupSlug });

                // 3. Await the recursive seedMenus call
                if (menuGroupData.menus && menuGroupData.menus.length) {
                    await this.seedMenus(menuGroupData.menus, null, groupData.id, seedingCode);
                }
            } catch (err) {
                console.error('Error in group processing:', err);
            }
        }));

        // 4. THIS PART ONLY RUNS AFTER ALL GROUPS AND MENUS ARE DONE
        await menuModel.destroy({
            where: {
                seedingCode: { [Op.ne]: seedingCode }
            },
        });
    }

    return res.status(200).json({
        status: true,
        message: "Menu data seeded successfully.",
        data: {},
    });
});

static seedMenus = async (subMenus, menuData, groupId, seedingCode) => {
    // 1. Create an array of promises for each item in the subMenus
    const promises = subMenus.map(async (menuObj) => {
        let menuLink = menuObj.link ? menuObj.link : null;
        let parentId = menuData ? menuData.id : null;
        let menuSlug = slugify(menuObj.name);

        // 2. Await the primary database operation
        const data = await super.upsert(menuModel, { 
            uuid: crypto.randomUUID(), 
            name: menuObj.name, 
            slug: menuSlug, 
            groupId, 
            parentId, 
            icon: menuObj.icon, 
            link: menuLink, 
            order: menuObj.order, 
            createdAt: new Date(), 
            updatedAt: new Date(), 
            seedingCode 
        }, { slug: menuSlug });

        // 3. Track and wait for all actions
        if (menuObj.actions && menuObj.actions.length) {
            const actionPromises = menuObj.actions.map(menuAction => {
                let permissionSlug = slugify(`${menuAction} ${data.name}`);
                return super.upsert(permissionModel, { 
                    menuId: data.id, 
                    name: menuAction, 
                    slug: permissionSlug, 
                    createdAt: new Date(), 
                    updatedAt: new Date() 
                }, { slug: permissionSlug });
            });
            await Promise.all(actionPromises);
        }

        // 4. Recurse and wait for nested sub-menus
        if (menuObj.menus && menuObj.menus.length) {
            await this.seedMenus(menuObj.menus, data, groupId, seedingCode);
        }
    });

    // 5. This ensures the function only "finishes" when all internal tasks are done
    return Promise.all(promises);
}

static createRandomString = (length) => {
    const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    let result = "";
    for (let i = 0; i < length; i++) {
        result += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return result;
}

static async upsert(modelName, values, condition) {
    return modelName
      .findOne({ where: condition })
      .then((obj) => {
          // update
          if(obj){
            delete values.uuid;
            obj.update(values);
            return obj;
          }                
          // insert
          return modelName.create(values);
      });
}