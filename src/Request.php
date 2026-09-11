<?php
class Request {
    private $data;

    public function __construct(){
        $this->data = $this->xss($_REQUEST);
    }

    public function __get($name){
        return isset($this->data[$name]) ? $this->data[$name] : false;
    }

    public function __isset($name){
        return isset($this->data[$name]);
    }

    private function xss($data){
        if (is_array($data)) {
            $escaped = array();
            foreach ($data as $key => $value){
                $escaped[$key] = $this->xss($value);
            }
            return $escaped;
        }
        return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
    }
}
?>