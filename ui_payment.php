<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
    <title>Flexbox Project</title>
</head>

<script>
    function paddle(){
    <Script src="https://cdn.paddle.com/paddle/paddle.js"
onLoad={() => {
    Paddle.Environment.set("sandbox");
    Paddle.setup({
        vendor:27220
    })
}} />}

</script>
<style>
    *,
*::after,
*::before {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Rubik', sans-serif;
    font-size: 18px;
}

.title {
    text-align: center;
    margin: 10px auto 50px auto;
    z-index: 1;
    margin-top: 100px;
}

h2 {
     margin-top: 20px;
}

h3 {
    margin-top: 40px;
}

p {
    margin: 20px 30px;
    font-size: 16px;
}

small {
    font-size: 12px;
    color: gray;
}

.small-colored {
    color: #47cf73;
}

 body::before,
 body::after {
    content:"";
    display: block;
    width: 0;
    height: 0;
    position: absolute;
    z-index: -1;
  }

  body::before {
    border-top: 30vw solid #47cf73;
    border-right: 30vw solid transparent;
    top:0;
    left:0;
  }
body::after {
    border-bottom: 30vw solid black;
    border-left: 30vw solid transparent;
    right: 0;
    margin-top: -50px;
  }

.container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    z-index: 1;
}

.offers {
    position: relative;
    text-align: center;
    background: #fff;
    padding: 1%;
    margin: 10px;
    width: 300px;
    height: auto;
    top: 0;
    border: 1px solid #eaeaea;
    z-index: 1;
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out; 
}

.offers:hover {
    position: relative;
    top: -20px;
    box-shadow: 0px 14px 6px 0px #0000004d;
}

.offers:nth-child(2) {
    border-top: 2px solid #47cf73;
    box-shadow: 0 0 10px 0px #0000001c;
}

.offers:nth-child(2) h3{
    margin-top: 20px;
}

.offers:nth-child(2):hover {
    box-shadow: 0px 14px 6px 0px #0000004d;
}

button {
    font-size: 22px;
    font-weight: 500;
    background: #0ebeff;
    color: #fff;
    margin: 30px auto 20px auto;
    padding: 4% 8%;
    border: 0;
    transition-duration: 0.5s;
}

button:hover {
     background: #47cf73;
}

</style>
<body>
    <paddle>
    <h1 class="title">Subscription Plans</h1>
    <div class="container">
        <div class="offers">
            <h2>Standard</h2>
            <h3 class="price">$50</h3>
            <small>Annually</small>
            <p>Up to 3 Websites</p>
            <p>Basic technical support</p>
            <p>Basic access to analytics</p>
            <button>Subscribe</button>
        </div>
        <div class="offers">
            <h2>Premium</h2>
            <small class="small-colored">Best offer!</small>
            <h3 class="price">$80</h3>
            <small>Annually</small>
            <p>Up to 50 Websites</p>
            <p>14/7 Support</p>
            <p>Limited analytics</p>
            <button>Subscribe</button>
        </div>
        <div class="offers">
            <h2>Enterprise</h2>
            <h3 class="price">$200</h3>
            <small>Annually</small>
            <p>Unlimited Websites</p>
            <p>24/7 Support</p>
            <p>Full Access to analytics</p>
            <button onclick="{() =>{
            Paddle.Checkout.open({
                product:pro_01jkchxx72f8ygz6ps0p3s9ade}}}">Subscribe</button>
        </div>
    </div>
</paddle>
</body>
</html>