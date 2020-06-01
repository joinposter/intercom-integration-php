<?php

namespace Intercom;

use Http\Client\Exception;
use stdClass;

class IntercomExport extends IntercomResource
{
    /**
     * Creates job.
     *
     * @see    https://developers.intercom.com/intercom-api-reference/v0/reference#creating-an-export-job
     * @param int $from - The start date that you request data for. It must be formatted as a unix timestamp.
     * @param int $to - The end date that you request data for. It must be formatted as a unix timestamp.
     * @return stdClass
     */
    public function create(int $from, int $to)
    {
        $options = [
            'created_at_after' => $from,
            'created_at_before' => $to,
        ];
        return $this->client->post("export/messages/data", $options);
    }

    /**
     * Get information about existed job.
     *
     * @see    https://developers.intercom.com/intercom-api-reference/v0/reference#checking-the-status-of-the-job
     * @param string $jobId
     * @param array $options
     * @return stdClass
     */
    public function info(string $jobId, ?array $options = [])
    {
        return $this->client->get("export/messages/data/$jobId", $options);
    }

    /**
     * Download csv export file.
     *
     * @see    https://developers.intercom.com/intercom-api-reference/v0/reference#downloading-the-data
     * @param string $path
     * @param string $intercomFilePath
     * @return false|int
     * @throws \Exception
     */
    public function retrieve(string $path, string $intercomFilePath)
    {
        $fileContent = $this->client->exportFile($intercomFilePath);

        return file_put_contents($path, $fileContent);
    }
}
