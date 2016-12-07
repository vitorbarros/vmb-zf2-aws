<?php
namespace VMBAWS;

abstract class Builder
{

    /**
     * @var array
     */
    protected $config;

    public function __construct()
    {
        $file = __DIR__ . '/../../../../../config/autoload/global.php';

        //verificando se o arquivo existe
        if (!file_exists($file)) {
            throw new \Exception("File {$file} dos not exists");
        }

        $config = include __DIR__ . '/../../../../../config/autoload/global.php';

        //verificando as configurações
        if (!isset($config['s3_credentials'])) {
            throw new \Exception("index 's3_credentials' dos not exists in file {$file}");
        }

        //verificando as configurações do Array
        if (!isset($config['s3_credentials']['Bucket']) || !isset($config['s3_credentials']['secret'])) {
            throw new \Exception("index 'bucket' or 'secret' dos not exists in file {$file}");
        }
        $this->config = $config;
    }
}