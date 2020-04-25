<?php

use Illuminate\Database\Capsule\Manager;

include_once 'ProvidersEntity.php';
    require __DIR__ . '/../utils/JsonResponse.php';

    class Repository
    {

        private $capsule;
        function __construct($config)
        {
            $this->capsule = new Manager;
            $this->capsule->addConnection($config['settings']['db']);
            $this->capsule->bootEloquent();
        }

        public function registerUser($parsedBody)
        {
            $response = new JsonResponse;
            try {
                if($parsedBody != null){
                    $fields = $parsedBody['data'];
                    foreach ($fields as $item){
                        $data = [
                            'provider_id' => $parsedBody['providerId'],
                            'name' => $item['name'],
                            'age' => $item['age'],
                            'timestamp' => $item['timestamp']
                        ];
                        $user = new ProvidersEntity;
                        $user->forceFill($data)->saveOrFail();
                    }

                    $desc = "Registration Successful!";
                    $response = new JsonResponse(true, $desc, $user);
                }
            }catch (Exception $e){
                $desc = "Error Occurs!";
                $response = new JsonResponse(false, $desc, $user);
            }
            return $response;

        }


        public function filterRecord($args, array $params)
        {
            $name = explode(':', $params['name']);
            $age = explode(':', $params['age']);
            $timestamp = explode(':', $params['timestamp']);

            $first = is_numeric(trim($age[1]));
            $second = is_string(trim($name[1]));
            $third = is_numeric(trim($timestamp[1]));
            if( $first && $second  && $third){
                $symbol = $timestamp == 'lt' ? '<' : '>';
                $db = $this->capsule->getConnection();
                $sql = "SELECT name, age, timestamp from providers_entity where provider_id = '". $args['providerId'] ."' or name = '". $name[1] ."' or age = ". $age[1] ." or timestamp " . $symbol . " " . $timestamp[1];
                return $db->select( $db->raw($sql) );
            }
            else
                return [];
        }


    }
