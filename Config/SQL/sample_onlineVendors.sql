INSERT INTO vendors (name, home_url, add_url) VALUES ('Presto Fresh Grocery', 'http://www.prestofreshgrocery.com/', 'http://www.prestofreshgrocery.com/checkout/cart/add/uenc/a/product/');
INSERT INTO vendors (name, home_url, add_url, request_type, format) 
    VALUES ('NetGrocer', 'http://shop.netgrocer.com', 'http://shop.netgrocer.com/Cart/AddItem/', 'POST', 
    '{"productId":%s,"brandId":"","quantity":1,"Size":-1,"UnitOfMeasure":"","isPointsRedemption":false,"origin":"Browse.aspx","reason":"endcap","maxItems":"3","currentItem":"2","circularItemId":""}');
