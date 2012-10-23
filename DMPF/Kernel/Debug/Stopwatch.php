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
        
        Public Function getName(){
            return $this->m_Name;
        }
        
        Public Function getElapsed(){
            return $this->Elapsed;
        }
        
        Public Static Function Create($Name, $AutoStart = true){
            $Stopwatch = new Stopwatch($Name);
            IF($AutoStart)
                $Stopwatch->Start();
            return $Stopwatch;
        }
        
        Public Static Function GetAll(){
            return self::$Watches;
        }
        
        Public Static Function Get($Name){
            IF(isset(self::$Watches[$Name]))
                return self::$Watches[$Name];
            return null;
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
            ?><script>console.log('<?=$this->m_Name?> Stopwatch <?=$this->Stop()?>');</script><?
        }
    }