<?
    /**
     * Split data to chunks
     * @param string $data input data
     * @param int $chunkSize chunk length
     * @return array chunks
     */
    Function Chunk($data, $chunkSize){
        $chunks = array();
        for($i = 0; $i < strlen($data) / $chunkSize; $i++)
            $chunks[] = substr($data, $i*$chunkSize, $chunkSize);
        return $chunks;
    }