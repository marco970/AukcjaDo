create table oferty  (
	bid_id int UNSIGNED not null auto_increment primary key,
	step_id int UNSIGNED,
	dost_name varchar( 40 ),
	offer_value varchar( 40 ),
	step_value varchar( 40 )
);