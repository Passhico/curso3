
/**
 * Author:  Pascual Muñoz 
 * Created: 24-nov-2016
 */

/* Totales Diarios  */
select 
	date(FROM_UNIXTIME(c.created_at_seconds)) as fecha, 
	count(*) as numero_de_chats, 
	avg(c.survey_score) as media_valoracion, 
	sum(if(c.survey_score is not null, 1, 0)) as n_valoraciones , 
	TIME_FORMAT(SEC_TO_TIME(sum(c.chat_duration)),'%Hh %im') tiempo_chateo
from 
	cases c 
where 
-- 	c.proactive_chat = true and
    c.user_agent <> ""

group by fecha
order by 
	fecha
;

/*Totales por oper*/
select 
	c.user_agent as operador, 
	count(*) as numero_de_chats, 
	avg(c.survey_score) as media_valoracion, 
	sum(if(c.survey_score is not null, 1, 0)) as n_valoraciones , 
	TIME_FORMAT(SEC_TO_TIME(sum(c.chat_duration)),'%Hh %im') tiempo_chateo
from 
	cases c 
where 
c.user_agent <> ""
-- 	c.proactive_chat = true
group by 
	c.user_agent
order by 
	c.user_agent
;

/*Totales by oper & fecha*/
select 
	date(FROM_UNIXTIME(c.created_at_seconds)) as fecha,
	c.user_agent as operador, 
	count(*) as numero_de_chats, 
	avg(c.survey_score) as media_valoracion, 
	sum(if(c.survey_score is not null, 1, 0)) as n_valoraciones , 
	TIME_FORMAT(SEC_TO_TIME(sum(c.chat_duration)),'%Hh %im') tiempo_chateo
from 
	cases c 
where 
	c.proactive_chat = true
group by 
	c.user_agent, 
	fecha
order by 
	fecha,
	c.user_agent
;
