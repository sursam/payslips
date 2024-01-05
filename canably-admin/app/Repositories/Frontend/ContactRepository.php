<?php
namespace App\Repositories\Frontend;

use App\Traits\UploadAble;
use Illuminate\Support\Str;
use App\Models\Contact;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use App\Contracts\Frontend\ContactContract;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class ContactRepository
 *
 * @package \App\Repositories
 */
class ContactRepository extends BaseRepository implements ContactContract
{
    use UploadAble;

    /**
     * ContactRepository constructor
     *
     * @param Contact $model
     */
    public function __construct(Contact $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * List of all Contacts
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listContacts(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create a Contact
     *
     * @param array $params
     * @return Contact|mixed
     */
    public function createContact(array $params)
    {
        try
        {
            $collection         = collect($params);
            $contact            = $this->model;
            $contact->uuid      = Str::uuid();
            $contact->name      = $collection['name'];
            $contact->email     = $collection['email'];
            $contact->subject     = $collection['subject'];
            $contact->comment   = $collection['comment'];
            $contact->status    = $collection['status'] ?? false;
            $contact->save();
            return $contact;
        }
        catch (QueryException $exception)
        {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * Update a Contact's status
     *
     * @param array $params
     * @return mixed
     */
    public function updateContactStatus(array $params)
    {
        $contact = $this->findPageById($params['id']);
        $collection = collect($params)->except('_token');
        $contact->status = $collection['check_status'];
        $contact->save();

        return $contact;
    }

    /**
     * Get list of pages for datatable
     *
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getList($start, $limit, $order, $dir, $search=null)
    {
        if($search)
        {
            return $this->model->where('name','LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else
        {
            return $this->model->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
    }

    /**
     * Get count of total contacts
     *
     * @param null $search
     * @return mixed
     */
    public function getTotalData($search=null)
    {
        if($search)
        {
            return $this->model->where('name','LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->count();
        }
        else
        {
            return $this->model->count();
        }
    }
}
