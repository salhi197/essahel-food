const BarcodeScanner = require("native-barcode-scanner");

const options = {}

const scanner = new BarcodeScanner(options);

scanner.on('code', code => {
  console.log(code);
  fetch('http://localhost:8000/api/ouverture', {
    method: 'post', 
    headers: {
      'Accept': 'application/json, text/plain, */*',
      'Content-Type': 'application/json'
    },
  })
  .then(res => res.json())
    .then(res => {
      console.log(res);
    })
    .catch(err=>function (err) {
      console.log("err.message")
  });

})
//apui6135204003381
// Remove the listener
scanner.off();
