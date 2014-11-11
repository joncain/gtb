<?php
include_once("include/header.php");

$template->assign("TITLE", "GetTotalBalance.com");

$page = "welcome";

if (isset($_GET["page"]) && file_exists("templates/" . $_GET["page"] . ".html"))
{
  $page = $_GET["page"];
}

$pageContent = new template("templates/$page.html");

$template->assign("PAGE", $_GET["page"]);
$template->assign("MAINCONTENT", $pageContent->template);

$template->parse();

include_once("include/footer.php");
?>