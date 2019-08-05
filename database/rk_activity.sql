DROP TABLE IF EXISTS reward_card_redemption;
CREATE TABLE IF NOT EXISTS reward_card_redemption
(
	reward_card_redemption_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	student_id INT UNSIGNED NOT NULL,
	reward_card_id INT UNSIGNED NOT NULL,
	redeemed_at DATETIME NOT NULL,
	PRIMARY KEY(reward_card_redemption_id),
	KEY(student_id),
	KEY (reward_card_id)
);