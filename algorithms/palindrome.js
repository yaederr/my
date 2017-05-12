function palindrome(str) {
  str= str.toLowerCase();
  var ptrA=0; var ptrB= str.length-1;
  for(var c=0; ptrA<ptrB; ptrA++,ptrB--){
    while(str.charAt(ptrA).match("[a-z0-9]") === null){
      ptrA++;
    }
    while(str.charAt(ptrB).match("[a-z0-9]") === null){
      ptrB--;
    }
    if(str.charAt(ptrA) !== str.charAt(ptrB)){
      return false;
    }
  }
  return true;
}
