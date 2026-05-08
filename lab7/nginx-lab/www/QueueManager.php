<?php

class QueueManager {
    private $topic = 'lab7_topic';
    private $producer;
    
    public function __construct() {
        if (extension_loaded('rdkafka')) {
            $conf = new RdKafka\Conf();
            $conf->set('metadata.broker.list', 'kafka:9092');
            $this->producer = new RdKafka\Producer($conf);
            $this->producer->addTopic($this->topic);
        }
    }
    
    public function publish($data) {
        if (!$this->producer) {
            $logFile = 'processed_kafka.log';
            $message = json_encode($data) . PHP_EOL;
            file_put_contents($logFile, $message, FILE_APPEND);
            return true;
        }
        
        // Отправляем в Kafka
        try {
            $topic = $this->producer->newTopic($this->topic);
            $payload = json_encode($data);
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload);
            $this->producer->flush(1000);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>