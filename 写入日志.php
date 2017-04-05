<?php

    /**
	 * 写入日志
	 * $word 需要写入的值 
	*/
    public function log_result($word) {
        $fp = fopen(ROOT_PATH . "log/log.txt", "a");
        flock($fp, LOCK_EX);
        fwrite($fp, "执行日期：" . strftime("%Y%m%d%H%M%S", time()) . "\n" . $word . "\n\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }

/**
 * 分页
 * $count_total总条数
 * $page_sum当前条数
 * $topicList需要分页的数组
 * $page_number当前页码数
 * 
 */
 function pagePage($page_sum,$page_number,$topicList)
 {
     $count_total = count($topicList);
     $merge_page = intval(floor($count_total / $page_sum)) + 1;//总页数
     $newarr['list'] = array_slice($topicList, ($page_number-1)*$page_sum, $page_sum);
     $merge['page'] = $merge_page;
     //合并数组
     $result = array_merge_recursive($newarr,$merge);
     return $result;
 }
