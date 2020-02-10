<?php

/**
 * Gets all tweets posted on the calendar day of a given DateTime.
 *
 * @param \PDO $pdo The database connection object.
 * @param DateTime $tweetDate The date on which to search for tweets.
 * @return \SplFixedArray An array of tweet objects that match the date.
 * @throws \PDOException MySQL errors generated by the statement.
 **/
public static function getTweetsByTweetDate(\PDO $pdo, DateTime $tweetDate) : \SplFixedArray {

	// Create dates for midnight of the date and midnight of the next day.
	$startDateString = $tweetDate->format('Y-m-d') . ' 00:00:00';
	$startDate = new DateTime($startDateString);
	$endDate = new DateTime($startDateString);
	$endDate->add(new DateInterval('P1D'));



	//getTasksByTaskParentId
	//getTasksByTaskParentIdAndTaskKidId
//getTaskByKidId