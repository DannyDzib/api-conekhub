<?php
    class Hash {


        public function encryptHash($param){
            $upass =  $param;
            $upassmd5s = md5($upass);
            $encrypt = crypt($upass, $upassmd5s);

            return $encrypt;
        }
    }

?>