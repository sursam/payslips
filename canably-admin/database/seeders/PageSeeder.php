<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::insert(/* [
            'name'=> 'About Us',
            'title'=> 'About Us',
            'uuid'=> Str::uuid(),
            'slug'=> 'about-us',
            'description'=> '<section class="about_us">
            <div class="faq_sechead">
                <h3>About Us</h3>
            </div>

            <div class="container">
                <div class="canably_box">
                    <h2>WHO IS CANABLY?</h2>
                    <p>Canably is a new and innovative company in the CBD industry. Canably provides a large range of CBD products and brands, all found and offered to you through one easy website. Discover new high-quality products that are organically grown and shipped and delivered to you easily. Canably is your one-stop-shop for your CBD needs, whether you’re a beginner or have regularly used CBD products.</p>
                    <button class="add-to-cart default-button submit_form">
                        <span>Submit</span>
                    </button>
                </div>
                <div class="canabt_img">
                    <img src="'.asset("assets/frontend/images/aboutus.jpg").'" class="img-fluid" alt="contact-img">
                </div>
                <div class="row d-flex align-items-center">
                    <div class="col-md-6">
                        <img src="'.asset("assets/frontend/images/commt-abt.jpg").'" class="img-fluid" alt="contact-img">

                    </div>
                    <div class="col-md-6">
                        <div class="commit-box">
                            <h3>OUR COMMITMENT</h3>
                            <p>
                                We take great pride in providing our customers with the best CBD products on the market. We only sell high-quality products that contain zero pesticides and are organically grown. We believe in the products we sell and we take plenty of measures to ensure our customers receive the best on the market.
                            </p>
                            <a class="add-to-cart default-button submit_form">
                                <span>Submit</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row strains_box">
                    <h2>THE EFFECTS OF SATIVA, INDICA, & HYBRID CANNABIS STRAINS</h2>
                    <div class="col-md-4">
                        <div class="strains_con strains_conyel">
                            <h4>SATIVA</h4>
                            <ul>
                                <li><span><i class="fa-solid fa-circle"></i></span>Increases energy, productivity, focus & creativity.</li>
                            </ul>
                            <a href="" class="white_btn">Day time use</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="strains_con strains_congrn">
                            <h4>INDICA</h4>
                            <ul>
                                <li><span><i class="fa-solid fa-circle"></i></span>Increases dopamine & appetite.</li>
                                <li><span><i class="fa-solid fa-circle"></i></span>Helps pain & nausea</li>
                                <li><span><i class="fa-solid fa-circle"></i></span>Muscle relaxer</li>
                            </ul>
                            <a href="" class="white_btn">Night time use</a>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="strains_con strains_conred">
                            <h4>HYBRID</h4>
                            <ul>
                                <li><span><i class="fa-solid fa-circle"></i></span>A combination of both sedative and energizing effects.</li>
                            </ul>
                            <a href="" class="white_btn">Multi-functional use</a>

                        </div>
                    </div>
                </div>

                <div class="row find_us">
                    <h3>WHERE TO FIND US </h3>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d107397.32713501833!2d-117.173509!3d32.73477!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80d954cad2cae189%3A0xef4f2c71c707feb7!2s2971%20India%20St%2C%20San%20Diego%2C%20CA%2092103!5e0!3m2!1sen!2sus!4v1688642951373!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <div class="col-md-6 findus_left">
                        <h4>LOCATION</h4>
                        <div class="find_usbox">
                            <a href="javascript:void(0)" class="">Canably</a>
                            <a href="javascript:void(0)" class="">4431 Balboa Ave 102. San Diego, CA. 92117</a>
                            <a href="javascript:void(0)" class="">United States of America</a>
                        </div>
                    </div>
                    <div class="col-md-6 findus_left">
                        <h4>CONTACT US</h4>
                        <div class="find_usbox">
                        <a href="tel:8004301415" class="">Phone: (800) 430-1415</a>
                        <a href="mailto:info@canably.com" class="">info@canably.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>',
            'created_by'=>1,
            'updated_by'=>1
        ], */[
            'name'=> 'Become Driver',
            'title'=> 'Become Driver',
            'uuid'=> Str::uuid(),
            'slug'=> 'become-driver',
            'description'=>'
            <div class="col-md-6 becomedownload">
            <img src="'.asset("assets/frontend/images/download.png").'" class="img-fluid mb-4" alt="">
        </div>
        <div class="col-md-6">
            <div class="downloada_cont">
                <h3>Provide Faster and Safer Delivery to Canably Customers</h3>
                <h4 class="download-con">Download App!</h4>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Minima consectetur fuga maiores
                    ipsa sit nihil, sunt cum quibusdam est. Blanditiis repellendus possimus vero laboriosam ex.
                </p>
                <h6>Download Available</h6>
                <a href="javascript:void(0)" class="add-to-cart default-button "><span> Download Now</span> </a>

            </div>
        </div>
        <div class="col-md-5">
            <div class="downloada_cont">
                <h3>Lorem reiciendis tempora Eos, natus.</h3>
                <h4 class="download-con">Register As a Driver!</h4>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Minima consectetur fuga maiores
                    ipsa sit nihil, sunt cum quibusdam est. Blanditiis repellendus possimus vero laboriosam ex.
                </p>

            </div>

        </div>
            ',
            'created_by'=>1,
            'updated_by'=>1
        ]
    );
    }
}
