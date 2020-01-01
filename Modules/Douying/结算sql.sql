CREATE DEFINER=`laravel_admin`@`localhost` PROCEDURE `dyjiesuan`(	 
IN `addmoeny` DECIMAL(15,4),
IN `son1` DECIMAL(15,4),
IN `son2` DECIMAL(15,4),
IN `minacc` INT)
BEGIN
		#Routine body goes here...
	 
	declare  v_id  bigint DEFAULT  0;   # 小号对应的ID

	declare  v_username  VARCHAR(224) DEFAULT  '';  
	declare  v_num  bigint DEFAULT  0;   # 小号对应的ID
	declare  v_num2  bigint DEFAULT  0;   # 小号对应的ID

  	DECLARE done INT DEFAULT FALSE;  # 遍历数据结束标志
	DECLARE cur_account CURSOR FOR SELECT userid, username,count(1)  from dy_codes where yishou = 1 and used = 1 and status=1   group by userid  ;
  	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE; #将结束标志绑定到游标
	-- ===================================================================
	  update dy_codes set gongzi = gongzi + addmoeny where  yishou = 1 and used = 1 and status=1 ;#小号各自累计自己的工资
    #游标:计算下级贡献给上级多少钱
		OPEN  cur_account;#打开游标  
    read_loop: LOOP #遍历
        FETCH  NEXT from cur_account INTO v_id, v_username,v_num;#取值 取多个字段
				IF done THEN  LEAVE read_loop; END IF;
				
				update dy_users set leiji = leiji + addmoeny*v_num, yue = yue + addmoeny*v_num ,gongxian = gongxian + addmoeny*v_num * (son1 + son2)  where  id = v_id ; #先给自己发钱
				
				select yaoqingren into v_username   from dy_users  where  username = v_username ;  #一代收益
				SELECT  count(1) into v_num2  from dy_codes where yishou = 1 and used = 1 and status=1 and  username = v_username ;
				IF v_num2 >= minacc   THEN
 					update dy_users set leiji = leiji + addmoeny*v_num*son1, yue = yue + addmoeny*v_num*son1   where  username = v_username ;
				END IF;
			 
			 	select yaoqingren into v_username   from dy_users  where  username = v_username ;  #二代收益
				SELECT  count(1) into v_num2  from dy_codes where yishou = 1 and used = 1 and status=1 and  username = v_username ;
				IF v_num2 >= minacc   THEN
 					 update dy_users set leiji = leiji + addmoeny*v_num*son2, yue = yue + addmoeny*v_num*son2   where  username = v_username ; 
				END IF;
			  
    END LOOP;
    CLOSE cur_account;
	-- ===================================================================	
	SELECT '执行成功!' result ;
		
		
END