<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$your_google_calendar="https://www.google.com/calendar/embed?src=usa__en@holiday.calendar.google.com&gsessionid=OK";
$url= parse_url($your_google_calendar);


// Load and parse Google's raw calendar
$dom = new DOMDocument('1.0', 'iso-8859-1');
$dom->loadHTMLfile($your_google_calendar);

// Change Google's CSS file to use absolute URLs (assumes there's only one element)
$css = $dom->getElementByTagName('link')->item(0);
$css_href = $css->getAttributes('href');
$css->setAttributes('href', $google_domain . $css_href);

// Change Google's JS file to use absolute URLs
$scripts = $dom->getElementByTagName('script')->item(0);
foreach ($scripts as $script) {
$js_src = $script->getAttributes('src');
if ($js_src) $script->setAttributes('src', $google_domain . $js_src);
}

// Create a link to a new CSS file called custom_calendar.css
$element = $dom->createElement('link');
$element->setAttribute('type', 'text/css');
$element->setAttribute('rel', 'stylesheet');
$element->setAttribute('href', 'custom_calendar.css');

// Append this link at the end of the element
$head = $dom->getElementByTagName('head')->item(0);
$head->appendChild($element);

// Export the HTML
echo $dom->saveHTML();
?>
</body>
</html>