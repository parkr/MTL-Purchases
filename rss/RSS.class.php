<?
# constants: 'PURCHASES_TABLE', 'BUSINESSES_TABLE', 'DATABASE_NAME'
  class RSS
  {
	public function RSS()
	{
		require_once ('../db.inc.php');
	}

	public function GetFeed()
	{
		return $this->getDetails() . $this->getItems();
	}

	private function dbConnect()
	{
		DEFINE ('LINK', mysql_connect('localhost', USER, PASS));
	}
	
	private function convertDate($date){
		$datetime = array();
		$datetime['hour'] = substr($date, 11, 2);
		$datetime['min'] = substr($date, 14, 2);
		$datetime['sec'] = substr($date, 17, 2);
		$datetime['month'] = substr($date, 5, 2);
		$datetime['day'] = substr($date, 8, 2);
		$datetime['year'] = substr($date, 0, 4);
		$time = mktime($datetime['hour'], $datetime['min'], $datetime['sec'], $datetime['month'], $datetime['day'], $datetime['year']);
		return date("D, d M Y H:i:s", $time);
	}

	private function getDetails()
	{
		$detailsTable = "montreal_rss";
		$this->dbConnect($detailsTable);
		$query = "SELECT * FROM ". $detailsTable;
		$result = mysql_db_query (DATABASE_NAME, $query, LINK);

		while($row = mysql_fetch_array($result))
		{
			$details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
				<rss version="2.0">
					<channel>
						<title>'. $row['title'] .'</title>
						<link>'. $row['link'] .'</link>
						<description>'. $row['description'] .'</description>
						<language>'. $row['language'] .'</language>
			';
						/*<image>
							<title>'. $row['image_title'] .'</title>
							<url>'. $row['image_url'] .'</url>
							<link>'. $row['image_link'] .'</link>
							<width>'. $row['image_width'] .'</width>
							<height>'. $row['image_height'] .'</height>
						</image>'*/
		}
		return $details;
	}

	private function getItems()
	{
		$itemsTable = PURCHASES_TABLE;
		$this->dbConnect($itemsTable);
		$query = "SELECT * FROM ". $itemsTable ." ORDER BY `datetime` DESC";
		$result = mysql_db_query (DATABASE_NAME, $query, LINK);
		$items = '';
		while($row = mysql_fetch_array($result))
		{
			
			$date = $this->convertDate($row['datetime']);
			$items .= '<item>
				<title>'. $row["currency"] .' $'. $row["amount"] .'</title>
				<pubDate>'. $date .' EST</pubDate>
				<link>http://mtl.parkr.me/view:'. $row["id"] .'</link>
				<description>'. htmlspecialchars($row["items"]) .' for '. htmlspecialchars($row["purpose"]) .'</description>
				<amount>'. $row['amount'] .'</amount>
			</item>
			';
		}
		$items .= '</channel>
				</rss>';
		return $items;
	}

}

?>