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
            if($parsedBody != null){
                $user = new ProvidersEntity;
                $fields = $parsedBody['data'];
                $data = [];
                foreach ($fields as $item){
                    $data[] = [
                        'providerId' => $parsedBody['providerId'],
                        'name' => $item['name'],
                        'age' => $item['age'],
                        'timestamp' => $item['timestamp']
                    ];
                }

                $result = $user->forceFill($data)->saveOrFail();
                $desc = $result ? "Registration Successful!" : "Error Occurs";
                $response = new JsonResponse($result, $desc, $user);
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
