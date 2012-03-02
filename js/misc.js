// validate upc/ean input
  function validate_str_size(str) {
  if(str==null||str=='') {
    alert("You need to enter a UPC/EAN!");
    return false; }
  if(str.length==0) {
    alert("You need to enter a UPC/EAN!");
    return false; }
  kittyCode();
  if(str.length!=7&&str.length!=8&&str.length!=11&&
	  str.length!=12&&str.length!=13) {
    alert("Invalid UPC/EAN!");
    return false; }
  if(str.length==7) {
    document.upcform.upc.value = fix_upce_checksum(str); }
  if(str.length==8&&!validate_upce(str,false)&&!validate_ean8(str,false)) {
    document.upcform.upc.value = fix_upce_checksum(str); }
  if(str.length==8&&validate_upce(str,false)) {
    document.upcform.upc.value = convert_upce_to_ean13(str); 
	str = document.upcform.upc.value; }
  if(str.length==8&&validate_ean8(str,false)) {
    document.upcform.upc.value = convert_ean8_to_ean13(str); 
	str = document.upcform.upc.value; }
  if(str.length==11) {
    document.upcform.upc.value = fix_upca_checksum(str); }
  if(str.length==12&&!validate_upca(str,false)) {
    document.upcform.upc.value = fix_upca_checksum(str); }
  if(str.length==12&&validate_upca(str,false)) {
    document.upcform.upc.value = convert_upca_to_ean13(str); 
	str = document.upcform.upc.value; }
  if(str.length==13&&!validate_ean13(str,false)) {
    document.upcform.upc.value = fix_ean13_checksum(str); }
  return true; }
