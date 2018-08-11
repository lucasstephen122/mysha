<?php

class Table
{
	public static $attachments = 'tbl_attachments';
	public static $users = 'tbl_users';
	public static $comments = 'tbl_comments';
	public static $logs = 'tbl_logs';
	public static $settings = 'tbl_settings';
	public static $notifications = 'tbl_notifications';
	public static $countries = 'tbl_countries';
	public static $universities = 'tbl_university';
}

class Status
{
	public static $DRAFT = 10 ;
	public static $SUBMITTED = 20 ;
	public static $APPROVED = 30 ;
	public static $REJECTED = 40 ;
	public static $PUBLISHED = 50 ;
	public static $BLOCKED = 60 ;
	public static $ACTIVE = 70 ;
	public static $INACTIVE = 80 ;
	public static $UNREAD = 90 ;
	public static $READ = 100 ;
	public static $DELEGATED = 110 ;
	public static $AWAITING = 120 ;
	public static $CONFIRMED = 130 ;
	public static $RETURNED = 140 ;
	public static $SKIPPED = 150 ;
	public static $ASSIGNED = 160 ;
	public static $TRANSFERRED = 170;
	public static $CANCELLED = 180;
	public static $CONSUMED = 190;
}

class ExceptionHandler
{
	public static $COMMON = 'common';
}

$config = array();
