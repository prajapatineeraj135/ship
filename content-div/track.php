<div class="section">
  <div class="track">
    <img src="images/gif/track.gif" alt="" class="truck">
    <h3>Track Shipment </h3>
    <form action="" method="POST">
      <input type="text" name="tracking_number" id="tracking_number" pattern="[0-9]+" placeholder="Enter Shipment/Contact" required>
      <button type="submit" name="track">Track Now</button>
    </form>
  </div>
</div>



<style>
  .track {
    padding: 10px;
    margin: 20px;
    justify-content: center;
    align-items: center;
    display: flex;
    flex-direction: column;
    background-color: rgb(141, 194, 255);
    border-radius: 30px 5px;
    border: 1px solid;
  
  }

  .track>img {
    mix-blend-mode: multiply;
    transform: scalex(-1);
    width: 75px;
    height: 75px;
  }

  .track>form {
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .track>form>input {
    padding: 15px;
    width: 250px;
    height: 20px;
    margin-bottom: 10px;
    border-radius: 5px;
    text-align: center;
    border: 2px solid;
  }

  .track>form>input::placeholder {
    font-weight: bold;
    font-size: small
  } 
  .track>form>button {
    width: fit-content;
    padding: 5px 20px;
    background-color: rgb(250, 250, 150);
    border: 1px solid;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    font-size: medium;
    box-shadow: 5px 5px 5px rgb(0, 0, 0);

  }
</style>