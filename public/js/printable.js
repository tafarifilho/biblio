function printElement(div) {

	var domClone = div.cloneNode(true);
	domClone.className = "";
	var $printSection = document.createElement("div");

	$printSection.id = "printSection";
	$printSection.appendChild(domClone);
	document.body.insertBefore($printSection, document.body.firstChild);

	window.print(); 

	// Clean up print section for future use
	var oldElem = document.getElementById("printSection");
	if (oldElem != null) { oldElem.parentNode.removeChild(oldElem); } 

	return true;
}