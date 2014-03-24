<?php

// Open the DB connection and select the DB - creates the function getCreativePagerLyte()
include_once('configurations.php');

// Gets the data
$id=isset($_POST['id']) ? $_POST['id'] : '';
$search=isset($_POST['search']) ? $_POST['search'] : '';
$multiple_search=isset($_POST['multiple_search']) ? $_POST['multiple_search'] : array();
$items_per_page=isset($_POST['items_per_page']) ? $_POST['items_per_page'] : '';
$sort=isset($_POST['sort']) ? $_POST['sort'] : '';
$page=isset($_POST['page']) ? $_POST['page'] : 1;
$total_items=(isset($_POST['total_items']) and $_POST['total_items']>=0) ? $_POST['total_items'] : '';
$extra_cols=isset($_POST['extra_cols']) ? $_POST['extra_cols'] : array();

// Uses the creativeTable to build the table
include_once('creativeTable.php');

$ct=new CreativeTable();

// Data Gathering
$params['sql_query']                = "SELECT * FROM form";
$params['search']                   = $search;
$params['multiple_search']          = $multiple_search;
$params['items_per_page']           = $items_per_page;
$params['sort']                     = $sort;
$params['page']                     = $page;
$params['total_items']              = $total_items;

// Layout Configurations
$params['header']                   = 'Rank,Rating,Title,Votes'; // If you need to use the comma use &#44; instead of ,
$params['width']                    = '45,60,,70';

// ***********************************************************************************
// UNCOMMENT TO TEST THE DIFFERENTS OPTIONS AND SEE THE RESULTS AND TEST SOME YOURSELF

$params['search_init']              = true;             // the search box will appear and it will search in all 4 fields (id, rating, title, votes)
//$params['search_init']            = false;            // the search box wont appear
//$params['search_init']            = 'fftf';           // only search the 3rd field (title) because the string 'fftf' is composed (False, False, True, False)

$params['search_type']              = 'like';           // this is the default option, searches words that looks like the keyword
//$params['search_type']            = '=';              // searches words that are equal to the keyword
//$params['search_type']            = 'beginning_like'; // searches words that the beginning looks like the keyword
//$params['search_type']            = 'end_like';       // searches words that the end looks like the keyword

//$params['search_html']            = '<span id="#ID#_search_value">Search...</span><a id="#ID#_advanced_search" href="javascript: ctShowAdvancedSearch(\'#ID#\');" title="Advanced Search"><img src="images/advanced_search.png" /></a><div id="#ID#_loader"></div>';  // this is the default option, so if you like the way it is you dont need to add this line of code
$params['search_html']              = '<a href="javascript: ctShowAdvancedSearch(\'#ID#\');" style="margin-left: 10px; color: #555555; text-decoration: none;">Show Advanced Search</a>';   // you can insert any html to configure the search input

//$params['multiple_search_init']   = true;             // will show the advanced search for all 4 fields (id, rating, title, votes) from the start
//$params['multiple_search_init']   = false;            // wont show the advanced search
$params['multiple_search_init']     = 'hide';           // will show the advanced search for all 4 fields (id, rating, title, votes) but in the beginning they are hidden, you may use a javascript function to show them
//$params['multiple_search_init']   = 'fftf';           // only show the advanced search for the 3rd filed (title) because the string 'fftf' is composed (False, False, True, False)
//$params['multiple_search_init']   = 'fftf hide';      // only show the advanced search for the 3rd filed (title) because the string 'fftf' is composed (False, False, True, False) but in the beginning they are hidden, you may use a javascript function to show them

$params['multiple_search_type']     = 'like';           // this is the default option, searches words that's looks like the keyword
//$params['multiple_search_type']   = '=';              // searches words that are equal to the keyword
//$params['multiple_search_type']   = 'beginning_like'; // searches words that the beginning looks like the keyword
//$params['multiple_search_type']   = 'end_like';       // searches words that the end looks like the keyword

// ***********************************************************************************

$ct->table($params);
$ct->pager = getCreativePagerLite('ct',$page,$ct->total_items,$ct->items_per_page);

// If its an ajax call
if($_POST['ajax_option']!=''){
    echo json_encode($ct->display($_POST['ajax_option'],true));
    exit;
}else{
    $out=$ct->display();
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
    <title>Creative Table - Examples - Search</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/creative.css">
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/creative_table_ajax-1.3.js"></script>
</head>

<body>

<a href="index.html" style="display: block; margin: 0px auto; width: 300px; height: 60px;"><img src="images/pix.gif" width="300" height="60" /></a>

<div id="container">

    <?php echo buildLayoutMenu(4); ?>

    <h1>Examples</h1>

    <h2>Search</h2>

    <p>Here you may test different search configuration to understand its behavior.</p>

    <p>
        <span class="green">$params</span>[<span class="orange">'search_init'</span>]           = <span class="blue">true</span>;&nbsp;&nbsp;<span class="gray">// all fields</span><br>
        <span class="green">$params</span>[<span class="orange">'search_init'</span>]           = <span class="blue">false</span>;&nbsp;&nbsp;<span class="gray">// no search</span><br>
        <span class="green">$params</span>[<span class="orange">'search_init'</span>]           = <span class="blue">'fftf'</span>;&nbsp;&nbsp;<span class="gray">// 3rd field only</span><br><br>

        <span class="green">$params</span>[<span class="orange">'search_type'</span>]           = <span class="blue">'like'</span>;&nbsp;&nbsp;<span class="gray">// default configuration, searches words that looks like the keyword</span><br>
        <span class="green">$params</span>[<span class="orange">'search_type'</span>]           = <span class="blue">'='</span>;&nbsp;&nbsp;<span class="gray">// searches words that are equal to the keyword</span><br>
        <span class="green">$params</span>[<span class="orange">'search_type'</span>]           = <span class="blue">'beginning_like'</span>;&nbsp;&nbsp;<span class="gray">// searches words that the beginning looks like the keyword</span><br>
        <span class="green">$params</span>[<span class="orange">'search_type'</span>]           = <span class="blue">'end_like'</span>;&nbsp;&nbsp;<span class="gray">// searches words that the end looks like the keyword</span><br><br>

        <span class="green">$params</span>[<span class="orange">'search_html'</span>]           = <span class="blue">'&#60;span id="#ID#_search_value"&#62;Search...&#60;/span&#62;&#60;a id="#ID#_advanced_search" href="javascript: ctShowAdvancedSearch(\'#ID#\');"&#62;&#60;img src="images/advanced_search.png" /&#62;&#60;/a&#62;&#60;div id="#ID#_loader"&#62;&#60;/div&#62;'</span>;&nbsp;&nbsp;<span class="gray">// default configuration</span><br>
        <span class="green">$params</span>[<span class="orange">'search_html'</span>]           = <span class="blue">'&#60;a href="javascript: ctShowAdvancedSearch(\'#ID#\');"&#62;Show Advanced Search&#60;/a&#62;'</span>;&nbsp;&nbsp;<span class="gray">// any html</span><br><br>

        <span class="green">$params</span>[<span class="orange">'multiple_search_init'</span>]  = <span class="blue">true</span>;&nbsp;&nbsp;<span class="gray">// all fields</span><br>
        <span class="green">$params</span>[<span class="orange">'multiple_search_init'</span>]  = <span class="blue">false</span>;&nbsp;&nbsp;<span class="gray">// no advanced search</span><br>
        <span class="green">$params</span>[<span class="orange">'multiple_search_init'</span>]  = <span class="blue">hide</span>;&nbsp;&nbsp;<span class="gray">// all fields but in beginnig they are hidden</span><br>
        <span class="green">$params</span>[<span class="orange">'multiple_search_init'</span>]  = <span class="blue">'fftf'</span>;&nbsp;&nbsp;<span class="gray">// 3rd field only</span><br>
        <span class="green">$params</span>[<span class="orange">'multiple_search_init'</span>]  = <span class="blue">'fftf hide'</span>;&nbsp;&nbsp;<span class="gray">// 3rd field only but in beginnig they are hidden</span><br>
    </p>

    <h2>IMDb Top 250</h2>

    <?php echo $out;?>

</div>

</body>

</html>