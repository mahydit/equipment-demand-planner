<?php


namespace App\Utils\API;

use JMS\Serializer\Annotation as Serializer;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

class ApiResponseTransformer
{

    /**
     * @Serializer\Groups("api_response")
     */
    protected $code;
    /**
     * @Serializer\Groups("api_response")
     */
    protected $message;
    /**
     * @Serializer\Groups("api_response")
     */
    protected $data;
    /**
     * @Serializer\Groups("api_response")
     */
    protected $errors;

    private $status;
    public function __construct($code, $data = null, $message = null,  $errors = null,$extra=null)
    {

        $this->setCode($code)
            ->setStatus($code)
            ->setData($data,$extra)
            ->setMessage($message)
            ->setErrors($errors);
    }

    function getCode()
    {
        return $this->code;
    }

    function getStaus()
    {
        return $this->status;
    }

    function getData()
    {
        return $this->data;
    }

    function getMessage()
    {
        return $this->message;
    }

    function getErrors()
    {
        return $this->errors;
    }

    function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    function setStatus($code)
    {

        $this->status = preg_match('/^2..$/', $code) ? TRUE : FALSE;
        return $this;
    }

    function setData($data,$extra=null)
    {
        $this->data = array();
        if (is_array($data)) :
            $this->data['items'] = $data;
        elseif ($data instanceof SlidingPagination) :
            $this->data['items'] = $data->getItems();
            $this->data['meta'] = $data->getPaginationData();
        else :
            $this->data['item'] = $data;
        endif;
        if($extra!==null){
          foreach($extra as $k=>$v){
            $this->data[$k] = $v;
          }
        }
        return $this;
    }

    function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    function setErrors($errors)
    {
        if (empty($errors)) :
            $this->errors = null;
        elseif (is_string($errors)) :
            $this->errors = ['default' => $errors];
        else :
            $this->errors = $errors;
        endif;

        return $this;
    }
}
