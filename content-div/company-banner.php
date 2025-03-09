<div class="section">
  <h2>Couriers Company</h2>
  <div class="banner-section" id="banner-section">
    <div class="banner-image" id="banner-image">
      <img src="images/company-banner/delhivery.jpg" alt="delhivery shipping">
      <img src="images/company-banner/xpressbees.jpg" alt="xpressbees shipping">
      <img src="images/company-banner/ekart.jpg" alt="ekart shipping">
      <img src="images/company-banner/dtdc.jpg" alt="dtdc shipping">
      <img src="images/company-banner/amazon.jpg" alt="amazon shipping">
      <img src="images/company-banner/shreemaruti.png" alt="shreemaruti shipping">
      <img src="images/company-banner/shadowfex.jpg" alt="shadowfex shipping">
      <img src="images/company-banner/bluedart.jpg" alt="bluedart shipping">
      <img src="images/company-banner/ecomexpress.jpg" alt="ecomexpress shipping">
    </div>
  </div>
</div>
</div>

<style>
  
  /* 207 line end other containt Start Here*/
  /*THIS IS THE CSS FOR THE COURIER PAGE*/
  .banner-section {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 auto;
    padding: 10px;
  }



  .banner-image {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 5px;
    margin-bottom: 20px;
    overflow: hidden;
    flex-wrap: wrap;
    /* Allow wrapping on smaller screens */
  }

  .banner-image>img {
    object-fit: cover;
    width: 6em;
    height: 6em;
    border: 2px solid #000;
    border-radius: 20px 5px 20px 5px;
  }


  /* Adjust for tablet and medium-sized screens */
  @media (max-width: 768px) {
    .banner-image img {
      width: 6em;
      height: 6em;
      margin: 5px;
    }
  }
</style>