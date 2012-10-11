<?

    Class Stopwatch {
        
        Protected $m_Name = '';
        Protected $m_Start = 0;
        Protected $m_End = 0;
        Protected $m_Work = false;
        Protected $Elapsed = 0;
        Protected Static $Watches = Array();
        
        Public Function Stopwatch($Name){
            $this->m_Name = $Name;
            self::$Watches[$Name] = $this;
        }
        
        Public Static Function Create($Name, $AutoStart = true){
            $Stopwatch = new Stopwatch($Name);
            IF($AutoStart)
                $Stopwatch->Start();
            return $Stopwatch;
        }
        
        Public Function Start(){
            $this->m_Work = true;
            $this->m_Start = microtime(1);
        }
        
        Public Function Stop(){
            IF(!$this->m_Work) return 0;
            $this->m_Work = false;
            $this->Elapsed = microtime(1) - $this->m_Start;
            return $this->Elapsed;
        }
        
        Public Function Log(){
            $this->Stop();
            ?><script>console.log('<?=$this->m_Name?> Stopwatch <?=$this->Elapsed?>');</script><?
        }
    }