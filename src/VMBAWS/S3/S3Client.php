<?php
namespace VMBAWS\S3;

use VMBAWS\Builder;
use Aws\S3\S3Client as S3ClientLib;

class S3Client extends Builder
{
    /**
     * @var S3ClientLib
     */
    private $s3;

    /**
     * S3Client constructor.
     * @param array $options
     * @internal param $bucketEndpoint
     * @internal param $version
     * @internal param $region
     */
    public function __construct(array $options)
    {
        parent::__construct();

        $data = array();

        if (isset($options['credentials'])) {
            $data = $options;
        } else {
            $data = array_merge_recursive($options, array(
                'credentials' => [
                    'key' => $this->config['s3_credentials']['Key'],
                    'secret' => $this->config['s3_credentials']['secret'],
                ]
            ));
        }

        $this->s3 = new S3ClientLib($data);
    }

    /**
     * @param $parameters
     * @return \Aws\Result
     * @throws \Exception
     */
    public function uploadFile($parameters)
    {
        unset($this->config['s3_credentials']['Key']);

        $data = array_merge_recursive($parameters, $this->config['s3_credentials']);

        try {
            return $this->s3->putObject($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}