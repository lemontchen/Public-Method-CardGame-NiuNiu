<?php

    /**
	 * 写入日志
	 */
    public function log_result($word) {
        $fp = fopen(ROOT_PATH . "log/log.txt", "a");
        flock($fp, LOCK_EX);
        fwrite($fp, "执行日期：" . strftime("%Y%m%d%H%M%S", time()) . "\n" . $word . "\n\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }
