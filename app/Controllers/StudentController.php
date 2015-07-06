<?php namespace Controllers;
use Services\Controller;

/**
 * Class StudentController example REST API
 *
 * @package Controllers
 */

class StudentController extends Controller
{

    protected $student;

    protected function init()
    {
        $this->student = $this->pdo->setObject('Models\\User');
    }

    /**
     * @method index verb GET
     *
     * @return string
     */
    public function index()
    {
        return 'index';
    }

    /**
     * @method create verb GET
     *
     * @return string
     */
    public function create()
    {
        return 'create';
    }

    /**
     * @method store verb POST
     *
     * @return string
     */
    public function store()
    {
        $options = [

            'username' => [
                'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            ]
        ];
        $result = filter_input_array(INPUT_POST, $options);
        $username = !empty($result['username']) ? $result['username'] : 'no-body';

        return "store: {$username}";
    }

    /**
     * @method show verb GET
     *
     * @param int $id
     * @return string
     */
    public function show($id)
    {
        $id = (int)$id;

        return "show: {$id}";
    }

    /**
     * edit verb GET
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $id = (int)$id;

        return "edit: {$id}";
    }

    /**
     * update verb PUT/PATCH
     *
     * @param $id
     * @return string
     */
    public function update($id)
    {
        $id = (int)$id;

        return "update: {$id}";
    }

    /**
     * destroy resource verb DELETE
     *
     * @param $id
     *
     * @return string
     */
    public function destroy($id)
    {
        $id = (int)$id;

        return "destroy: {$id}";
    }

}