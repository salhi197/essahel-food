const BarcodeScanner = require("native-barcode-scanner");
const fetch = require("node-fetch")

const options = {}

const scanner = new BarcodeScanner(options);

scanner.on('code', code => {
  console.log(code);
  fetch('https://app.essahel-food.com/api/scan/depot', {
    method: 'post', 
    headers: {
      'Accept': 'application/json, text/plain, */*',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({code:code})  
  })
  .then(res => res.json())
    .then(res => {
      console.log(res);
    })
    .catch(err=>function (err) {
      console.log("err.message")
  });

})
scanner.off();
