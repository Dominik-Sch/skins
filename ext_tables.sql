#
# Table structure for table 'be_users'
#
CREATE TABLE be_users
(
    tx_skins_active             int(1) DEFAULT 0                                                                                                                                               NOT NULL,
    tx_skins_dark_mode_settings text   DEFAULT '{"color-1":"#151515","color-2":"#292929","color-4":"#3c3f41","color-5":"#f5f5f5","color-6":"#808080","color-7":"#1f1f1f","color-8":"#fdc300"}' NOT NULL
);