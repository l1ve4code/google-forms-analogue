<?php
    class simpleLabel{

        private $name;
        private $uuid;

        public function __construct($name, $uuid)
        {
            $this->name = $name;
            $this->uuid = $uuid;
        }

        public function getSubjectName(){
            return $this->name;
        }
        public function getSubjectUUID(){
            return $this->uuid;
        }
        public function getNameOfClass(){
            return static::class;
        }

    }

    class hardLabel extends simpleLabel{

        private $data_array = [];

        public function __construct($name, $uuid, $data_array)
        {
            parent::__construct($name, $uuid);
            $this->data_array = $data_array;
        }

        public function getSubjectData(){
            return $this->data_array;
        }

    }
?>