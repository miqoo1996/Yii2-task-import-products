<?php

namespace console\queue;

use backend\models\ImportProductJob;
use common\models\StoreProduct;
use common\services\FileImportAdapter;
use yii\helpers\Console;
use yii\queue\Queue;

class StoreProductImportJob extends QueueAbstract
{
    public int $store_id;
    public string $fileName;
    public string $extension;

    public function run(Queue $queue)
    {
        $file = $this->fileName . '.' . $this->extension;

        Console::output("NEW: $file is already in the queue!");

        $data = FileImportAdapter::instance($this->extension)->load($file)->toArray();

        Console::output("PROCESSING: $file is being processed!");
        ImportProductJob::saveLog($this->store_id, ImportProductJob::STATUS_PROCESSING, $this->toArray());
        (new StoreProduct())->addMultipleProduct($data, $this->store_id);

        Console::output("DONE: $file has been completed!");
        ImportProductJob::saveLog($this->store_id, ImportProductJob::STATUS_DONE, $this->toArray());
    }

    public function toArray()
    {
        return [
            'store_id' => $this->store_id,
            'fileName' => $this->fileName,
            'extension' => $this->extension,
        ];
    }
}