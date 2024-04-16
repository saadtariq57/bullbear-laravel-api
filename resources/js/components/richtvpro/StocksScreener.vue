<template>
  <div class="container my-4">
  <div class="screener-filter-wrapper border shadow-sm rounded-2">
    <div
      class="filter-header d-flex align-items-center justify-content-between flex-wrap gap-1 border-bottom border-dark border-2 py-2 px-2 bg-light">
      <h1 class="fs-3 fw-5 mb-0">Filter options</h1>
      <div class="fiter-search d-flex align-items-center gap-2">
        <div class="position-relative d-flex align-items-center">
          <input type="text" class="form-control border shadow-sm fiter-search-field rounded-0"
            id="exampleFormControlInputText" placeholder="Tickers (seperate by commas)">
          <button class="btn btn-primary px-3 py-2 fiter-search-btn rounded-0"><i
              class="bi bi-search fs-6"></i></button>
        </div>
      </div>
    </div>
    <div class="filter d-flex align-items-center justify-content-between flex-wrap gap-4 px-3 py-3 my-2 overflow-auto">
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Country</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option selected>Any</option>
          <option value="united-states">United States</option>
          <option value="china">China</option>
          <option value="ireland">Ireland</option>
          <option value="luxembourg">Luxembourg</option>
          <option value="germany">Germany</option>
          <option value="canada">Canada</option>
          <option value="switzerland">Switzerland</option>
          <option value="united-kingdom">United Kingdom</option>
          <option value="belgium">Belgium</option>
          <option value="denmark">Denmark</option>
          <option value="bermuda">Bermuda</option>
          <option value="netherlands">Netherlands</option>
          <option value="south-africa">South Africa</option>
          <option value="mexico">Mexico</option>
          <option value="taiwan">Taiwan</option>
          <option value="uruguay">Uruguay</option>
          <option value="spain">Spain</option>
          <option value="singapore">Singapore</option>
          <option value="sweden">Sweden</option>
          <option value="brazil">Brazil</option>
          <option value="israel">Israel</option>
          <option value="argentina">Argentina</option>
          <option value="monaco">Monaco</option>
          <option value="australia">Australia</option>
          <option value="turkey">Turkey</option>
          <option value="colombia">Colombia</option>
          <option value="chile">Chile</option>
          <option value="new-zealand">New Zealand</option>
          <option value="japan">Japan</option>
          <option value="norway">Norway</option>
          <option value="hong-kong">Hong Kong</option>
          <option value="france">France</option>
          <option value="austria">Austria</option>
          <option value="italy">Italy</option>
          <option value="thailand">Thailand</option>
          <option value="malaysia">Malaysia</option>
          <option value="india">India</option>
          <option value="greece">Greece</option>
          <option value="south-korea">South Korea</option>
          <option value="peru">Peru</option>
          <option value="panama">Panama</option>
          <option value="cayman-islands">Cayman Islands</option>
          <option value="indonesia">Indonesia</option>
          <option value="finland">Finland</option>
          <option value="bahamas">Bahamas</option>
          <option value="russia">Russia</option>
          <option value="philippines">Philippines</option>
          <option value="macau">Macau</option>
          <option value="portugal">Portugal</option>
          <option value="united-arab-emirates">United Arab Emirates</option>
          <option value="romania">Romania</option>
          <option value="guernsey">Guernsey</option>
          <option value="jersey">Jersey</option>
          <option value="netherlands-antilles">Netherlands Antilles</option>
          <option value="belize">Belize</option>
          <option value="poland">Poland</option>
          <option value="cambodia">Cambodia</option>
          <option value="british-virgin-islands">British Virgin Islands</option>
          <option value="papua-new-guinea">Papua New Guinea</option>
          <option value="gibraltar">Gibraltar</option>
          <option value="tanzania">Tanzania</option>
          <option value="cyprus">Cyprus</option>
          <option value="czech-republic">Czech Republic</option>
          <option value="lebanon">Lebanon</option>
          <option value="myanmar">Myanmar</option>
          <option value="malta">Malta</option>
          <option value="ghana">Ghana</option>
          <option value="mauritius">Mauritius</option>
          <option value="isle-of-man">Isle of Man</option>
          <option value="ukraine">Ukraine</option>
          <option value="dominican-republic">Dominican Republic</option>
          <option value="egypt">Egypt</option>
          <option value="anguilla">Anguilla</option>
          <option value="macedonia">Macedonia</option>
          <option value="hungary">Hungary</option>
          <option value="vietnam">Vietnam</option>
          <option value="channel-islands">Channel Islands</option>
          <option value="kazakhstan">Kazakhstan</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">P/E</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="p_e_u">Profitable (Over 0)</option>
          <option value="p_e_15">Low (&lt;15)</option>
          <option value="p_e_50">High (&gt;50)</option>
          <option value="p_e_u_1">Under 1</option>
          <option value="p_e_u_3">Under 3</option>
          <option value="p_e_u_5">Under 5</option>
          <option value="p_e_u_1_3">1 to 3</option>
          <option value="p_e_u_3_5">3 to 5</option>
          <option value="p_e_u_5_10">5 to 10</option>
          <option value="p_e_u_10_50">10 to 50</option>
          <option value="p_e_u_50_100">50 to 100</option>
          <option value="p_e_o_1">Over 1</option>
          <option value="p_e_o_3">Over 3</option>
          <option value="p_e_o_5">Over 5</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Return on Assets</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="roa_up">Postive (&gt;0%)</option>
          <option value="roa_d">Negative (&lt;0%)</option>
          <option value="roa_up_0_5">0% to 5%</option>
          <option value="roa_up_5_10">5% to 10%</option>
          <option value="roa_up_10_25">10% to 25%</option>
          <option value="roa_up_25_50">25% to 50%</option>
          <option value="roa_up_50_100">50% to 100%</option>
          <option value="roa_up_100">Over +100%</option>
          <option value="roa_down_0_5">0% to -5%</option>
          <option value="roa_down_5_10">-5% to -10%</option>
          <option value="roa_down_10_25">-10% to -25%</option>
          <option value="roa_down_25_50">-25% to -50%</option>
          <option value="roa_down_50_100">-50% to -100%</option>
          <option value="roa_down_100">Under -100%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">EPS this Y</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="epsy_u">Low (Under 1%)</option>
          <option value="epsy_u_25">High (&gt;25%)</option>
          <option value="epsy_u_1_10">1% to 10%</option>
          <option value="epsy_u_1_20">10% to 20%</option>
          <option value="epsy_u_20_30">20% to 30%</option>
          <option value="epsy_u_30">Under 30%</option>
          <option value="epsy_o_30">Above 30%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Float</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="flt_50">Under 1M</option>
          <option value="flt_u_50">Under 50M</option>
          <option value="flt_u_100">Under 100M</option>
          <option value="flt_u_500">Under 500M</option>
          <option value="flt_u_1000">Under 1Bn</option>
          <option value="flt_1_5">1M to 5M</option>
          <option value="flt_5_10">5M to 10M</option>
          <option value="flt_10_50">10M to 50M</option>
          <option value="flt_50_100">50M to 100M</option>
          <option value="flt_o_50">Over 50M</option>
          <option value="flt_o_100">Over 100M</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Industry</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="consumer-electronics">Consumer Electronics</option>
          <option value="banksdiversified">Banks—Diversified</option>
          <option value="internet-retail">Internet Retail</option>
          <option value="telecom-services">Telecom Services</option>
          <option value="internet-content-information">Internet Content &amp; Information</option>
          <option value="tobacco">Tobacco</option>
          <option value="airlines">Airlines</option>
          <option value="aluminum">Aluminum</option>
          <option value="credit-services">Credit Services</option>
          <option value="chemicals">Chemicals</option>
          <option value="medical-devices">Medical Devices</option>
          <option value="apparel-manufacturing">Apparel Manufacturing</option>
          <option value="semiconductor-equipment-materials">Semiconductor Equipment &amp; Materials</option>
          <option value="drug-manufacturersgeneral">Drug Manufacturers—General</option>
          <option value="insurancediversified">Insurance—Diversified</option>
          <option value="insuranceproperty-casualty">Insurance—Property &amp; Casualty</option>
          <option value="softwareinfrastructure">Software—Infrastructure</option>
          <option value="information-technology-services">Information Technology Services</option>
          <option value="steel">Steel</option>
          <option value="drugs-generic">Drugs - Generic</option>
          <option value="oil-gas-ep">Oil &amp; Gas E&amp;P</option>
          <option value="staffing-employment-services">Staffing &amp; Employment Services</option>
          <option value="reitmortgage">REIT—Mortgage</option>
          <option value="electronic-gaming-multimedia">Electronic Gaming &amp; Multimedia</option>
          <option value="softwareapplication">Software—Application</option>
          <option value="farm-products">Farm Products</option>
          <option value="pharmaceutical-retailers">Pharmaceutical Retailers</option>
          <option value="biotechnology">Biotechnology</option>
          <option value="semiconductors">Semiconductors</option>
          <option value="utilitiesregulated-electric">Utilities—Regulated Electric</option>
          <option value="banksregional">Banks—Regional</option>
          <option value="gold">Gold</option>
          <option value="apparel-retail">Apparel Retail</option>
          <option value="diagnostics-research">Diagnostics &amp; Research</option>
          <option value="specialty-retail">Specialty Retail</option>
          <option value="auto-truck-dealerships">Auto &amp; Truck Dealerships</option>
          <option value="utilitiesdiversified">Utilities—Diversified</option>
          <option value="beveragesbrewers">Beverages—Brewers</option>
          <option value="medical-instruments-supplies">Medical Instruments &amp; Supplies</option>
          <option value="steel-iron">Steel &amp; Iron</option>
          <option value="asset-management">Asset Management</option>
          <option value="insurancelife">Insurance—Life</option>
          <option value="household-personal-products">Household &amp; Personal Products</option>
          <option value="capital-markets">Capital Markets</option>
          <option value="utilitiesregulated-water">Utilities—Regulated Water</option>
          <option value="oil-gas-midstream">Oil &amp; Gas Midstream</option>
          <option value="marine-shipping">Marine Shipping</option>
          <option value="mortgage-finance">Mortgage Finance</option>
          <option value="reitresidential">REIT—Residential</option>
          <option value="thermal-coal">Thermal Coal</option>
          <option value="healthcare-plans">Healthcare Plans</option>
          <option value="silver">Silver</option>
          <option value="medical-distribution">Medical Distribution</option>
          <option value="metal-fabrication">Metal Fabrication</option>
          <option value="security-protection-services">Security &amp; Protection Services</option>
          <option value="business-equipment-supplies">Business Equipment &amp; Supplies</option>
          <option value="specialty-business-services">Specialty Business Services</option>
          <option value="utilitiesregulated-gas">Utilities—Regulated Gas</option>
          <option value="insurance-brokers">Insurance Brokers</option>
          <option value="reitretail">REIT—Retail</option>
          <option value="electrical-equipment-parts">Electrical Equipment &amp; Parts</option>
          <option value="reitspecialty">REIT—Specialty</option>
          <option value="engineering-construction">Engineering &amp; Construction</option>
          <option value="electronics-computer-distribution">Electronics &amp; Computer Distribution</option>
          <option value="entertainment">Entertainment</option>
          <option value="rental-leasing-services">Rental &amp; Leasing Services</option>
          <option value="water-utilities">Water Utilities</option>
          <option value="consulting-services">Consulting Services</option>
          <option value="specialty-chemicals">Specialty Chemicals</option>
          <option value="insurancespecialty">Insurance—Specialty</option>
          <option value="electronic-components">Electronic Components</option>
          <option value="aerospace-defense">Aerospace &amp; Defense</option>
          <option value="pollution-treatment-controls">Pollution &amp; Treatment Controls</option>
          <option value="building-products-equipment">Building Products &amp; Equipment</option>
          <option value="computer-hardware">Computer Hardware</option>
          <option value="farm-heavy-construction-machinery">Farm &amp; Heavy Construction Machinery</option>
          <option value="publishing">Publishing</option>
          <option value="utilitiesindependent-power-producers">Utilities—Independent Power Producers</option>
          <option value="restaurants">Restaurants</option>
          <option value="railroads">Railroads</option>
          <option value="packaging-containers">Packaging &amp; Containers</option>
          <option value="auto-parts">Auto Parts</option>
          <option value="drug-manufacturersspecialty-generic">Drug Manufacturers—Specialty &amp; Generic</option>
          <option value="specialty-industrial-machinery">Specialty Industrial Machinery</option>
          <option value="broadcasting">Broadcasting</option>
          <option value="reithotel-motel">REIT—Hotel &amp; Motel</option>
          <option value="food-distribution">Food Distribution</option>
          <option value="medical-care-facilities">Medical Care Facilities</option>
          <option value="reitdiversified">REIT—Diversified</option>
          <option value="airports-air-services">Airports &amp; Air Services</option>
          <option value="health-information-services">Health Information Services</option>
          <option value="furnishings-fixtures-appliances">Furnishings, Fixtures &amp; Appliances</option>
          <option value="industrial-equipment-wholesale">Industrial Equipment Wholesale</option>
          <option value="reithealthcare-facilities">REIT—Healthcare Facilities</option>
          <option value="solar">Solar</option>
          <option value="reitoffice">REIT—Office</option>
          <option value="textile-manufacturing">Textile Manufacturing</option>
          <option value="communication-equipment">Communication Equipment</option>
          <option value="oil-gas-equipment-services">Oil &amp; Gas Equipment &amp; Services</option>
          <option value="oil-gas-integrated">Oil &amp; Gas Integrated</option>
          <option value="waste-management">Waste Management</option>
          <option value="apparel-stores">Apparel Stores</option>
          <option value="industrial-distribution">Industrial Distribution</option>
          <option value="education-training-services">Education &amp; Training Services</option>
          <option value="other-industrial-metals-mining">Other Industrial Metals &amp; Mining</option>
          <option value="packaged-foods">Packaged Foods</option>
          <option value="integrated-freight-logistics">Integrated Freight &amp; Logistics</option>
          <option value="industrial-electrical-equipment">Industrial Electrical Equipment</option>
          <option value="trucking">Trucking</option>
          <option value="lodging">Lodging</option>
          <option value="agricultural-inputs">Agricultural Inputs</option>
          <option value="insurancereinsurance">Insurance—Reinsurance</option>
          <option value="real-estate-services">Real Estate Services</option>
          <option value="scientific-technical-instruments">Scientific &amp; Technical Instruments</option>
          <option value="footwear-accessories">Footwear &amp; Accessories</option>
          <option value="oil-gas-refining-marketing">Oil &amp; Gas Refining &amp; Marketing</option>
          <option value="diversified-electronics">Diversified Electronics</option>
          <option value="beverageswineries-distilleries">Beverages—Wineries &amp; Distilleries</option>
          <option value="auto-manufacturers-major">Auto Manufacturers - Major</option>
          <option value="real-estatediversified">Real Estate—Diversified</option>
          <option value="other-precious-metals-mining">Other Precious Metals &amp; Mining</option>
          <option value="lumber-wood-production">Lumber &amp; Wood Production</option>
          <option value="reitindustrial">REIT—Industrial</option>
          <option value="real-estatedevelopment">Real Estate—Development</option>
          <option value="auto-manufacturers">Auto Manufacturers</option>
          <option value="beveragesnon-alcoholic">Beverages—Non-Alcoholic</option>
          <option value="property-casualty-insurance">Property &amp; Casualty Insurance</option>
          <option value="shell-companies">Shell Companies</option>
          <option value="home-improvement-retail">Home Improvement Retail</option>
          <option value="medical-laboratories-research">Medical Laboratories &amp; Research</option>
          <option value="leisure">Leisure</option>
          <option value="conglomerates">Conglomerates</option>
          <option value="cigarettes">Cigarettes</option>
          <option value="tools-accessories">Tools &amp; Accessories</option>
          <option value="multimedia-graphics-software">Multimedia &amp; Graphics Software</option>
          <option value="residential-construction">Residential Construction</option>
          <option value="basic-materials-wholesale">Basic Materials Wholesale</option>
          <option value="broadcasting-tv">Broadcasting - TV</option>
          <option value="travel-services">Travel Services</option>
          <option value="luxury-goods">Luxury Goods</option>
          <option value="copper">Copper</option>
          <option value="building-materials">Building Materials</option>
          <option value="personal-services">Personal Services</option>
          <option value="money-center-banks">Money Center Banks</option>
          <option value="advertising-agencies">Advertising Agencies</option>
          <option value="regional-mid-atlantic-banks">Regional - Mid-Atlantic Banks</option>
          <option value="resorts-casinos">Resorts &amp; Casinos</option>
          <option value="internet-software-services">Internet Software &amp; Services</option>
          <option value="discount-stores">Discount Stores</option>
          <option value="regional-southeast-banks">Regional - Southeast Banks</option>
          <option value="department-stores">Department Stores</option>
          <option value="diversified-communication-services">Diversified Communication Services</option>
          <option value="regional-northeast-banks">Regional - Northeast Banks</option>
          <option value="grocery-stores">Grocery Stores</option>
          <option value="recreational-vehicles">Recreational Vehicles</option>
          <option value="general-building-materials">General Building Materials</option>
          <option value="utilitiesrenewable">Utilities—Renewable</option>
          <option value="regional-southwest-banks">Regional - Southwest Banks</option>
          <option value="financial-conglomerates">Financial Conglomerates</option>
          <option value="savings-loans">Savings &amp; Loans</option>
          <option value="cleaning-products">Cleaning Products</option>
          <option value="food-wholesale">Food Wholesale</option>
          <option value="marketing-services">Marketing Services</option>
          <option value="regional-pacific-banks">Regional - Pacific Banks</option>
          <option value="wireless-communications">Wireless Communications</option>
          <option value="independent-oil-gas">Independent Oil &amp; Gas</option>
          <option value="aerospacedefense-products-services">Aerospace/Defense Products &amp; Services</option>
          <option value="telecom-services-domestic">Telecom Services - Domestic</option>
          <option value="financial-data-stock-exchanges">Financial Data &amp; Stock Exchanges</option>
          <option value="confectioners">Confectioners</option>
          <option value="oil-gas-drilling-exploration">Oil &amp; Gas Drilling &amp; Exploration</option>
          <option value="computers-wholesale">Computers Wholesale</option>
          <option value="semiconductor-broad-line">Semiconductor - Broad Line</option>
          <option value="uranium">Uranium</option>
          <option value="entertainment-diversified">Entertainment - Diversified</option>
          <option value="semiconductor-specialized">Semiconductor - Specialized</option>
          <option value="paper-paper-products">Paper &amp; Paper Products</option>
          <option value="electric-utilities">Electric Utilities</option>
          <option value="beverages-soft-drinks">Beverages - Soft Drinks</option>
          <option value="staffing-outsourcing-services">Staffing &amp; Outsourcing Services</option>
          <option value="foreign-utilities">Foreign Utilities</option>
          <option value="gambling">Gambling</option>
          <option value="music-video-stores">Music &amp; Video Stores</option>
          <option value="investment-brokerage-national">Investment Brokerage - National</option>
          <option value="shipping">Shipping</option>
          <option value="specialty-retail-other">Specialty Retail, Other</option>
          <option value="oil-gas-drilling">Oil &amp; Gas Drilling</option>
          <option value="diversified-machinery">Diversified Machinery</option>
          <option value="internet-information-providers">Internet Information Providers</option>
          <option value="discount-variety-stores">Discount, Variety Stores</option>
          <option value="specialized-health-services">Specialized Health Services</option>
          <option value="business-services">Business Services</option>
          <option value="regional-midwest-banks">Regional - Midwest Banks</option>
          <option value="application-software">Application Software</option>
          <option value="infrastructure-operations">Infrastructure Operations</option>
          <option value="technical-services">Technical Services</option>
          <option value="coking-coal">Coking Coal</option>
          <option value="oil-gas-pipelines">Oil &amp; Gas Pipelines</option>
          <option value="diversified-utilities">Diversified Utilities</option>
          <option value="air-services-other">Air Services, Other</option>
          <option value="diversified-investments">Diversified Investments</option>
          <option value="business-software-services">Business Software &amp; Services</option>
          <option value="textile-apparel-footwear-accessories">Textile - Apparel Footwear &amp; Accessories</option>
          <option value="closed-end-fund-equity">Closed-End Fund - Equity</option>
          <option value="processed-packaged-goods">Processed &amp; Packaged Goods</option>
          <option value="drug-stores">Drug Stores</option>
          <option value="management-services">Management Services</option>
          <option value="medical-appliances-equipment">Medical Appliances &amp; Equipment</option>
          <option value="networking-communication-devices">Networking &amp; Communication Devices</option>
          <option value="industrial-metals-minerals">Industrial Metals &amp; Minerals</option>
          <option value="catv-systems">CATV Systems</option>
          <option value="trucks-other-vehicles">Trucks &amp; Other Vehicles</option>
          <option value="reit-office">REIT - Office</option>
          <option value="home-furnishings-fixtures">Home Furnishings &amp; Fixtures</option>
          <option value="medical-practitioners">Medical Practitioners</option>
          <option value="electronic-equipment">Electronic Equipment</option>
          <option value="semiconductor-integrated-circuits">Semiconductor - Integrated Circuits</option>
          <option value="internet-service-providers">Internet Service Providers</option>
          <option value="drug-manufacturers-other">Drug Manufacturers - Other</option>
          <option value="healthcare-information-services">Healthcare Information Services</option>
          <option value="diagnostic-substances">Diagnostic Substances</option>
          <option value="property-management">Property Management</option>
          <option value="diversified-computer-systems">Diversified Computer Systems</option>
          <option value="food-major-diversified">Food - Major Diversified</option>
          <option value="real-estate-development">Real Estate Development</option>
          <option value="long-distance-carriers">Long Distance Carriers</option>
          <option value="drug-manufacturers-major">Drug Manufacturers - Major</option>
          <option value="home-improvement-stores">Home Improvement Stores</option>
          <option value="information-delivery-services">Information &amp; Delivery Services</option>
          <option value="sporting-activities">Sporting Activities</option>
          <option value="agricultural-chemicals">Agricultural Chemicals</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Forward P/E</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="fwd_pe_u">Profitable (Over 0)</option>
          <option value="fwd_pe_15">Low (&lt;15)</option>
          <option value="fwd_pe_50">High (&gt;50)</option>
          <option value="fwd_pe_u_1">Under 1</option>
          <option value="fwd_pe_u_3">Under 3</option>
          <option value="fwd_pe_u_5">Under 5</option>
          <option value="fwd_pe_u_1_3">1 to 3</option>
          <option value="fwd_pe_u_3_5">3 to 5</option>
          <option value="fwd_pe_u_5_10">5 to 10</option>
          <option value="fwd_pe_u_10_50">10 to 50</option>
          <option value="fwd_pe_u_50_100">50 to 100</option>
          <option value="fwd_pe_o_1">Over 1</option>
          <option value="fwd_pe_o_3">Over 3</option>
          <option value="fwd_pe_o_5">Over 5</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Return on Equity</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="roe_up">Postive (&gt;0%)</option>
          <option value="roe_d">Negative (&lt;0%)</option>
          <option value="roe_up_0_5">0% to 5%</option>
          <option value="roe_up_5_10">5% to 10%</option>
          <option value="roe_up_10_25">10% to 25%</option>
          <option value="roe_up_25_50">25% to 50%</option>
          <option value="roe_up_50_100">50% to 100%</option>
          <option value="roe_up_100">Over +100%</option>
          <option value="roe_down_0_5">0% to -5%</option>
          <option value="roe_down_5_10">-5% to -10%</option>
          <option value="roe_down_10_25">-10% to -25%</option>
          <option value="roe_down_25_50">-25% to -50%</option>
          <option value="roe_down_50_100">-50% to -100%</option>
          <option value="roe_down_100">Under -100%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">EPS next Y</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="epsny_u">Low (Under 1%)</option>
          <option value="epsny_u_25">High (&gt;25%)</option>
          <option value="epsny_u_1_10">1% to 10%</option>
          <option value="epsny_u_1_20">10% to 20%</option>
          <option value="epsny_u_20_30">20% to 30%</option>
          <option value="epsny_u_30">Under 30%</option>
          <option value="epsny_o_30">Above 30%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Float Short</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="fltsht_u">Low (Under 5%)</option>
          <option value="fltsht_u_25">High (&gt;20%)</option>
          <option value="fltsht_u_5_10">5% to 10%</option>
          <option value="fltsht_u_1_20">10% to 20%</option>
          <option value="fltsht_u_20_30">20% to 30%</option>
          <option value="fltsht_u_30">Under 30%</option>
          <option value="fltsht_o_30">Above 30%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Sector</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="technology">Technology</option>
          <option value="financial-services">Financial Services</option>
          <option value="consumer-cyclical">Consumer Cyclical</option>
          <option value="communication-services">Communication Services</option>
          <option value="consumer-defensive">Consumer Defensive</option>
          <option value="industrials">Industrials</option>
          <option value="basic-materials">Basic Materials</option>
          <option value="healthcare">Healthcare</option>
          <option value="energy">Energy</option>
          <option value="real-estate">Real Estate</option>
          <option value="utilities">Utilities</option>
          <option value="consumer-goods">Consumer Goods</option>
          <option value="conglomerates">Conglomerates</option>
          <option value="services">Services</option>
          <option value="financial">Financial</option>
          <option value="industrial-goods">Industrial Goods</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Price/Book</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="pb_u">Low (Under 1)</option>
          <option value="pb_5">High (&gt;5)</option>
          <option value="pb_u_5">Under 5</option>
          <option value="pb_u_10">Under 10</option>
          <option value="pb_u_15">Under 15</option>
          <option value="pb_u_100">Under 100</option>
          <option value="pb_b_1_3">1 to 3</option>
          <option value="pb_b_3_5">3 to 5</option>
          <option value="pb_b_5_10">5 to 10</option>
          <option value="pb_b_10_50">10 to 50</option>
          <option value="pb_b_50_100">50 to 100</option>
          <option value="pb_o_100">Over 100</option>
          <option value="pb_o_5">Over 5</option>
          <option value="pb_o_10">Over 10</option>
          <option value="pb_o_15">Over 15</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Current Ratio</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="curr_r_up">Low (&lt;1)</option>
          <option value="curr_r_up_5">High (&gt;3)</option>
          <option value="curr_r_up_0_1">0 to 1</option>
          <option value="curr_r_up_1_2">1 to 2</option>
          <option value="curr_r_up_2_3">2 to 3</option>
          <option value="curr_r_up_3_5">3 to 5</option>
          <option value="curr_r_up_5_10">5 to 10</option>
          <option value="curr_r_u_3">Under 3</option>
          <option value="curr_r_u_5">Under 5</option>
          <option value="curr_r_u_10">Under 10</option>
          <option value="curr_r_o_3">Over 3</option>
          <option value="curr_r_o_5">Over 5</option>
          <option value="curr_r_o_10">Over 10</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">EPS past 5Y</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="epsp5y_u">Low (Under 1%)</option>
          <option value="epsp5y_u_25">High (&gt;25%)</option>
          <option value="epsp5y_u_1_10">1% to 10%</option>
          <option value="epsp5y_u_1_20">10% to 20%</option>
          <option value="epsp5y_u_20_30">20% to 30%</option>
          <option value="epsp5y_u_30">Under 30%</option>
          <option value="epsp5y_o_30">Above 30%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Shares Outstanding</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="outstd_50">Under 1M</option>
          <option value="outstd_u_50">Under 50M</option>
          <option value="outstd_u_100">Under 100M</option>
          <option value="outstd_1_5">1M to 5M</option>
          <option value="outstd_5_10">5M to 10M</option>
          <option value="outstd_10_50">10M to 50M</option>
          <option value="outstd_50_100">50M to 100M</option>
          <option value="outstd_o_50">Over 50M</option>
          <option value="outstd_o_100">Over 100M</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Market Cap</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="cap_mega">Mega (200bln &amp; more)</option>
          <option value="cap_large">Large (10bln to 200bln)</option>
          <option value="cap_mid">Mid (2bln to 10bln)</option>
          <option value="cap_small">Small (300mln to 2bln)</option>
          <option value="cap_nano">Nano (under 50mln)</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">PEG</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="peg_up">Low (&lt;1)</option>
          <option value="peg_u_2">Under 2</option>
          <option value="peg_u_5">Under 5</option>
          <option value="peg_u_10">Under 10</option>
          <option value="peg_o_5">Over 5</option>
          <option value="peg_o_10">Over 10</option>
          <option value="peg_o_15">Over 15</option>
          <option value="peg_up_0_1">0 to 1</option>
          <option value="peg_up_1_2">1 to 2</option>
          <option value="peg_up_2_3">2 to 3</option>
          <option value="peg_up_3_5">3 to 5</option>
          <option value="peg_up_5">High (&gt;5)</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Debt/Equity</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="debteq_l">Low (&lt;0.1)</option>
          <option value="debteq_h">High (&gt;0.5)</option>
          <option value="debteq_u_1">Under 1</option>
          <option value="debteq_u_3">Under 3</option>
          <option value="debteq_u_5">Under 5</option>
          <option value="debteq_u_10">Under 10</option>
          <option value="debteq_u_20">Under 20</option>
          <option value="debteq_u_25">Under 25</option>
          <option value="debteq_u_30">Under 30</option>
          <option value="debteq_o_1">Over 1</option>
          <option value="debteq_o_3">Over 3</option>
          <option value="debteq_o_5">Over 5</option>
          <option value="debteq_o_10">Over 10</option>
          <option value="debteq_o_20">Over 20</option>
          <option value="debteq_o_25">Over 25</option>
          <option value="debteq_o_30">Over 30</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">EPS next 5Y</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="epsn5y_u">Low (Under 1%)</option>
          <option value="epsn5y_u_25">High (&gt;25%)</option>
          <option value="epsn5y_u_1_10">1% to 10%</option>
          <option value="epsn5y_u_1_20">10% to 20%</option>
          <option value="epsn5y_u_20_30">20% to 30%</option>
          <option value="epsn5y_u_30">Under 30%</option>
          <option value="epsn5y_o_30">Above 30%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Insider Own</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="insido_u_10">Low (Under 10%)</option>
          <option value="insido_u_25">High (&gt;30%)</option>
          <option value="insido_u_2">Over 20%</option>
          <option value="insido_u_3">Over 30%</option>
          <option value="insido_u_4">Over 40%</option>
          <option value="insido_u_5">Over 50%</option>
          <option value="insido_u_6">Over 60%</option>
          <option value="insido_u_7">Over 70%</option>

        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Change(%)</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="chg_up">Up</option>
          <option value="chg_down">Down</option>
          <option value="chg_u_1">Under 10%</option>
          <option value="chg_u_3">Under 25%</option>
          <option value="chg_u_5">Under 50%</option>
          <option value="chg_up_0_5">Up 0% to 5%</option>
          <option value="chg_up_5_10">Up 5% to 10%</option>
          <option value="chg_up_10_25">Up 10% to 25%</option>
          <option value="chg_up_25_50">Up 25% to 50%</option>
          <option value="chg_up_50_100">Up 50% to 100%</option>
          <option value="chg_up_100">Up +100%</option>
          <option value="chg_down_0_5">Down 0% to 5%</option>
          <option value="chg_down_5_10">Down 5% to 10%</option>
          <option value="chg_down_10_25">Down 10% to 25%</option>
          <option value="chg_down_25_50">Down 25% to 50%</option>
          <option value="chg_down_50_100">Down 50% to 100%</option>
          <option value="chg_down_100">Down -100%</option>
          <option value="chg_o_1">Over 10%</option>
          <option value="chg_o_3">Over 25%</option>
          <option value="chg_o_5">Over 50%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Earnings</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="earnings_today">Today</option>
          <option value="earnings_tomo">Tomorrow</option>
          <option value="earnings_y">Yesterday</option>
          <option value="earnings_tw">This Week</option>
          <option value="earnings_nw">Next Week</option>
          <option value="earnings_lw">Last Week</option>
          <option value="earnings_tm">This Month</option>
          <option value="earnings_nm">Next Month</option>

        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Dividend Yield</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="div_n">None (0%)</option>
          <option value="div_u">Positive (Under 1%)</option>
          <option value="div_a_10">High (&gt;10%)</option>
          <option value="div_u_5">Under 5%</option>
          <option value="div_u_10">Under 10%</option>
          <option value="div_u_15">Under 15%</option>
          <option value="div_u_1_5">1% to 5%</option>
          <option value="div_u_5_10">5% to 10%</option>
          <option value="div_0_1">Over 1%</option>
          <option value="div_0_5">Over 5%</option>
          <option value="div_0_10">Over 10%</option>
          <option value="div_0_15">Over 15%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Beta</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="beta_o">Under 0</option>
          <option value="beta_up">Under 0.5</option>
          <option value="beta_u_5">Under 5</option>
          <option value="beta_up_5_1">0.5 to 1</option>
          <option value="beta_up_1_2">1 to 2</option>
          <option value="beta_up_2_3">2 to 3</option>
          <option value="beta_up_3_5">3 to 5</option>
          <option value="beta_o_1">Over 1</option>
          <option value="beta_o_3">Over 3</option>
          <option value="beta_o_5">Over 5</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Institutional Own</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Price</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="price_u_1">Under 1</option>
          <option value="price_u_3">Under 3</option>
          <option value="price_u_5">Under 5</option>
          <option value="price_u_10">Under 10</option>
          <option value="price_u_50">Under 50</option>
          <option value="price_u_100">Under 100</option>
          <option value="vol_b_1_3">1 to 3</option>
          <option value="vol_b_3_5">1 to 5</option>
          <option value="vol_b_5_10">1 to 10</option>
          <option value="vol_b_10_50">10 to 50</option>
          <option value="vol_b_50_100">50 to 100</option>
          <option value="price_o_1">Over 1</option>
          <option value="price_o_3">Over 3</option>
          <option value="price_o_5">Over 5</option>
          <option value="price_o_10">Over 10</option>
          <option value="price_o_50">Over 50</option>
          <option value="vol_o_100">Over 100</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Profit Margin</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="profit_m_up">Postive (&gt;0%)</option>
          <option value="profit_m_d">Negative (&lt;0%)</option>
          <option value="profit_m_up_0_5">0% to 5%</option>
          <option value="profit_m_up_5_10">5% to 10%</option>
          <option value="profit_m_up_10_25">10% to 25%</option>
          <option value="profit_m_up_25_50">25% to 50%</option>
          <option value="profit_m_up_50_100">50% to 100%</option>
          <option value="profit_m_up_25">Under +25%</option>
          <option value="profit_m_up_50">Under +50%</option>
          <option value="profit_m_up_100">Under +100%</option>
          <option value="profit_m_o_25">Over +25%</option>
          <option value="profit_m_o_50">Over +50%</option>
          <option value="profit_m_o_100">Over +100%</option>
          <option value="profit_m_down_0_5">0% to -5%</option>
          <option value="profit_m_down_5_10">-5% to -10%</option>
          <option value="profit_m_down_10_25">-10% to -25%</option>
          <option value="profit_m_down_25_50">-25% to -50%</option>
          <option value="profit_m_down_50_100">-50% to -100%</option>
          <option value="profit_m_down_100">Under -100%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Gross Margin</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="gross_m_up">Postive (&gt;0%)</option>
          <option value="gross_m_d">Negative (&lt;0%)</option>
          <option value="gross_m_up_0_5">0% to 5%</option>
          <option value="gross_m_up_5_10">5% to 10%</option>
          <option value="gross_m_up_10_25">10% to 25%</option>
          <option value="gross_m_up_25_50">25% to 50%</option>
          <option value="gross_m_up_50_100">50% to 100%</option>
          <option value="gross_m_up_25">Under +25%</option>
          <option value="gross_m_up_50">Under +50%</option>
          <option value="gross_m_u_100">Under +100%</option>
          <option value="gross_m_o_25">Over +25%</option>
          <option value="gross_m_o_50">Over +50%</option>
          <option value="gross_m_o_100">Over +100%</option>
          <option value="gross_m_down_0_5">0% to -5%</option>
          <option value="gross_m_down_5_10">-5% to -10%</option>
          <option value="gross_m_down_10_25">-10% to -25%</option>
          <option value="gross_m_down_25_50">-25% to -50%</option>
          <option value="gross_m_down_50_100">-50% to -100%</option>
          <option value="gross_m_down_100">Under -100%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Operating Margin</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="oper_m_up">Postive (&gt;0%)</option>
          <option value="oper_m_d">Negative (&lt;0%)</option>
          <option value="oper_m_up_25">Under 25%</option>
          <option value="oper_m_up_50">Under 50%</option>
          <option value="oper_m_up_100">Under 100%</option>
          <option value="oper_m_up_0_5">0% to 5%</option>
          <option value="oper_m_up_5_10">5% to 10%</option>
          <option value="oper_m_up_10_25">10% to 25%</option>
          <option value="oper_m_up_25_50">25% to 50%</option>
          <option value="oper_m_up_50_100">50% to 100%</option>
          <option value="oper_m_down_0_5">0% to -5%</option>
          <option value="oper_m_down_5_10">-5% to -10%</option>
          <option value="oper_m_down_10_25">-10% to -25%</option>
          <option value="oper_m_down_25_50">-25% to -50%</option>
          <option value="oper_m_down_50_100">-50% to -100%</option>
          <option value="oper_m_o_25">Over +25%</option>
          <option value="oper_m_o_50">Over +50%</option>
          <option value="oper_m_o_100">Over +100%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Ern Qtrly Grth</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="ernqtrgrth_up">Postive (&gt;0%)</option>
          <option value="ernqtrgrth_d">Negative (&lt;0%)</option>
          <option value="ernqtrgrth_up_0_5">0% to 5%</option>
          <option value="ernqtrgrth_up_5_10">% to 10%</option>
          <option value="ernqtrgrth_up_10_50">10% to 50%</option>
          <option value="ernqtrgrth_up_50_100">50% to 100%</option>
          <option value="ernqtrgrth_up_25">Under +25%</option>
          <option value="ernqtrgrth_up_50">Under +50%</option>
          <option value="ernqtrgrth_up_100">Under +100%</option>
          <option value="ernqtrgrth_o_100">Over +100%</option>
          <option value="ernqtrgrth_down_0_5">0% to -5%</option>
          <option value="ernqtrgrth_down_5_10">w -5% to -10%</option>
          <option value="ernqtrgrth_down_10_50">-10% to -50%</option>
          <option value="ernqtrgrth_down_50_100">-50% to -100%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Volume</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="vol_u_50">Under 50K</option>
          <option value="vol_u_50">Under 100K</option>
          <option value="vol_u_50">Under 500K</option>
          <option value="vol_u_100">Under 1M</option>
          <option value="vol_b_50_100">50K to 100K</option>
          <option value="vol_b_50_500">50K to 500K</option>
          <option value="vol_b_50_1000">500K to 1M</option>
          <option value="vol_b_1000_2000">1M to 2M</option>
          <option value="vol_b_1000_5000">1M to 5M</option>
          <option value="vol_b_5000_10000">5M to 10M</option>
          <option value="vol_b_10000_20000">10M to 20M</option>
          <option value="vol_o_50">Over 50K</option>
          <option value="vol_o_100">Over 100K</option>
          <option value="vol_o_500">Over 500K</option>
          <option value="vol_o_1000">Over 1M</option>
          <option value="vol_o_5000">Over 5M</option>
          <option value="vol_o_20000">Over 20M</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">50D Avg Chg</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="50davgchg_up">Postive (&gt;0%)</option>
          <option value="50davgchg_d">Negative (&lt;0%)</option>
          <option value="50davgchg_up_0_5">0% to 5%</option>
          <option value="50davgchg_up_5_10">5% to 10%</option>
          <option value="50davgchg_up_10_50">10% to 50%</option>
          <option value="50davgchg_up_50_100">50% to 100%</option>
          <option value="50davgchg_u_25">Under +25%</option>
          <option value="50davgchg_u_50">Under +50%</option>
          <option value="50davgchg_u_100">Under +100%</option>
          <option value="50davgchg_o_50">Over +50%</option>
          <option value="50davgchg_o_100">Over +100%</option>
          <option value="50davgchg_d_0_5">0% to -5%</option>
          <option value="50davgchg_d_5_10">-5% to -10%</option>
          <option value="50davgchg_d_10_50">-10% to -50%</option>
          <option value="50davgchg_d_50_100">-50% to -100%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">200D Avg Chg</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="200davgchg_up">Postive (&gt;0%)</option>
          <option value="200davgchg_d">Negative (&lt;0%)</option>
          <option value="200davgchg_up_0_5">0% to 5%</option>
          <option value="200davgchg_up_5_10">5% to 10%</option>
          <option value="200davgchg_up_10_50">10% to 50%</option>
          <option value="200davgchg_up_50_100">50% to 100%</option>
          <option value="200davgchg_u_25">Under +25%</option>
          <option value="200davgchg_u_50">Under +50%</option>
          <option value="200davgchg_u_100">Under +100%</option>
          <option value="200davgchg_o_50">Over +50%</option>
          <option value="200davgchg_o_100">Over +100%</option>
          <option value="200davgchg_d_0_5">0% to -5%</option>
          <option value="200davgchg_d_5_10">-5% to -10%</option>
          <option value="200davgchg_d_10_50">-10% to -50%</option>
          <option value="200davgchg_d_50_100">-50% to -100%</option>

        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">52W High Chg</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="52wkhchg_up">Postive (&gt;0%)</option>
          <option value="52wkhchg_d">Negative (&lt;0%)</option>
          <option value="52wkhchg_up_0_5">0% to 5%</option>
          <option value="52wkhchg_up_0_10">0% to 10%</option>
          <option value="52wkhchg_up_10_50">10% to 50%</option>
          <option value="52wkhchg_up_50_100">50% to 100%</option>
          <option value="52wkhchg_u_25">Under +25%</option>
          <option value="52wkhchg_u_50">Under +50%</option>
          <option value="52wkhchg_u_100">Under +100%</option>
          <option value="52wkhchg_o_50">Over +50%</option>
          <option value="52wkhchg_o_100">Over +100%</option>
          <option value="52wkhchg_down_0_5">0% to -5%</option>
          <option value="52wkhchg_d_0_10">0% to -10%</option>
          <option value="52wkhchg_d_10_50">-10% to -50%</option>
          <option value="52wkhchg_d_50_100">-50% to -100%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">52W Low Chg</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="52wklchg_up">Postive (&gt;0%)</option>
          <option value="52wklchg_d">Negative (&lt;0%)</option>
          <option value="52wklchg_up_0_5">0% to 5%</option>
          <option value="52wklchg_up_0_10">0% to 10%</option>
          <option value="52wklchg_up_10_50">10% to 50%</option>
          <option value="52wklchg_up_50_100">50% to 100%</option>
          <option value="52wklchg_u_25">Under +25%</option>
          <option value="52wklchg_u_50">Under +50%</option>
          <option value="52wklchg_u_100">Under +100%</option>
          <option value="52wklchg_o_50">Over +50%</option>
          <option value="52wklchg_o_100">Over +100%</option>
          <option value="52wklchg_down_0_5">0% to -5%</option>
          <option value="52wklchg_d_0_10">0% to -10%</option>
          <option value="52wklchg_d_10_50">-10% to -50%</option>
          <option value="52wklchg_d_50_100">-50% to -100%</option>
        </select>
      </div>
      <div class="select-filter-wrapper d-flex align-items-center gap-2">
        <div class="filter-heading text-center">
          <h3 class="fs-6 fw-6 mb-0">Analyst Recom.</h3>
        </div>
        <select class="form-select filter-field-border form-select-filter">
          <option value="">Any</option>
          <option value="recomm_sb">Strong Buy (1)</option>
          <option value="recomm_1_5">Buy or better</option>
          <option value="recomm_2_5">Buy</option>
          <option value="recomm_1_3">Hold or better</option>
          <option value="recomm_2_3">Hold</option>
          <option value="recomm_1_35">Hold or worse</option>
          <option value="recomm_35_4">Sell</option>
          <option value="recomm_37_4">Sell or worse</option>
          <option value="recomm_ss">Strong Sell (5)</option>
        </select>
      </div>

    </div>
    <div class="indicator-wrapper">
      <h2 class="fs-5 fw-6 border-bottom px-2">Technical Indicators</h2>
      <div class="px-4 py-2">
        <div class="btn-group d-flex align-items-center justify-content-between flex-wrap gap-4" role="group" aria-label="Basic checkbox toggle button group">
          <div>
            <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
            <label class="btn btn-outline-primary fw-5 indicators-checkbox-btn" for="btncheck1">SMA</label>
          </div>
          <div>
            <input type="checkbox" class="btn-check" id="btncheck2" autocomplete="off">
            <label class="btn btn-outline-primary fw-5 indicators-checkbox-btn" for="btncheck2">RSI</label>
          </div>
          <div>
            <input type="checkbox" class="btn-check" id="btncheck3" autocomplete="off">
            <label class="btn btn-outline-primary fw-5 indicators-checkbox-btn" for="btncheck3">MACD</label>
          </div>
          <div>
            <input type="checkbox" class="btn-check" id="btncheck4" autocomplete="off">
            <label class="btn btn-outline-primary fw-5 indicators-checkbox-btn" for="btncheck4">CCI</label>
          </div>
          <div>
            <input type="checkbox" class="btn-check" id="btncheck5" autocomplete="off">
            <label class="btn btn-outline-primary fw-5 indicators-checkbox-btn" for="btncheck5">ADX</label>
          </div>
          <div>
            <input type="checkbox" class="btn-check" id="btncheck6" autocomplete="off">
            <label class="btn btn-outline-primary fw-5 indicators-checkbox-btn" for="btncheck6">EMA</label>
          </div>
          <div>
            <input type="checkbox" class="btn-check" id="btncheck7" autocomplete="off">
            <label class="btn btn-outline-primary fw-5 indicators-checkbox-btn" for="btncheck7">STOCH</label>
          </div>
          <div>
            <input type="checkbox" class="btn-check" id="btncheck8" autocomplete="off">
            <label class="btn btn-outline-primary fw-5 indicators-checkbox-btn" for="btncheck8">ABOSC</label>
          </div>
          <div>
            <input type="checkbox" class="btn-check" id="btncheck9" autocomplete="off">
            <label class="btn btn-outline-primary fw-5 indicators-checkbox-btn" for="btncheck9">AD</label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="screener-table-wrapper">
    <ul class="nav nav-pills mb-3 justify-content-between border" id="pills-tab" role="tablist">
      <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link fw-6 screener-table-tabs-btn w-100 active" id="pills-overview-tab" data-bs-toggle="pill"
          data-bs-target="#pills-overview" type="button" role="tab" aria-controls="pills-overview"
          aria-selected="true">Overview</button>
      </li>
      <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link fw-6 screener-table-tabs-btn w-100" id="pills-valuation-tab" data-bs-toggle="pill"
          data-bs-target="#pills-valuation" type="button" role="tab" aria-controls="pills-valuation"
          aria-selected="false">Valuation</button>
      </li>
      <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link fw-6 screener-table-tabs-btn w-100" id="pills-financial-tab" data-bs-toggle="pill"
          data-bs-target="#pills-financial" type="button" role="tab" aria-controls="pills-financial"
          aria-selected="false">Financial</button>
      </li>
      <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link fw-6 screener-table-tabs-btn w-100" id="pills-ownership-tab" data-bs-toggle="pill"
          data-bs-target="#pills-ownership" type="button" role="tab" aria-controls="pills-ownership"
          aria-selected="false">Ownership</button>
      </li>
      <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link fw-6 screener-table-tabs-btn w-100" id="pills-performance-tab" data-bs-toggle="pill"
          data-bs-target="#pills-performance" type="button" role="tab" aria-controls="pills-performance"
          aria-selected="false">Performance</button>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab"
        tabindex="0">
        <div class="overflow-auto screener-table-wapper">
          <table class="table screener-table-width border">
            <thead>
              <tr>
                <th class="fw-6">Ticker</th>
                <th class="text-center fw-6">Company</th>
                <th class="text-center fw-6">Industry</th>
                <th class="text-center fw-6">Sector</th>
                <th class="text-center fw-6">Country</th>
                <th class="text-center fw-6">Market Cap</th>
                <th class="text-center fw-6">Price</th>
                <th class="text-center fw-6">Change</th>
                <th class="text-center fw-6">Volume</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="fw-5">AAPL</td>
                <td class="text-center">Apple Inc.</td>
                <td class="text-center">Consumer Electronics</td>
                <td class="text-center">Technology</td>
                <td class="text-center">USA</td>
                <td class="text-center">3.03T</td>
                <td class="text-center">192.58</td>
                <td class="text-center Red">-1.55%</td>
                <td class="text-center">49,656,509</td>
              </tr>
              <tr>
                <td class="fw-5">AAPL</td>
                <td class="text-center">Apple Inc.</td>
                <td class="text-center">Consumer Electronics</td>
                <td class="text-center">Technology</td>
                <td class="text-center">USA</td>
                <td class="text-center">3.03T</td>
                <td class="text-center">192.58</td>
                <td class="text-center Red">-1.55%</td>
                <td class="text-center">49,656,509</td>
              </tr>
              <tr>
                <td class="fw-5">AAPL</td>
                <td class="text-center">Apple Inc.</td>
                <td class="text-center">Consumer Electronics</td>
                <td class="text-center">Technology</td>
                <td class="text-center">USA</td>
                <td class="text-center">3.03T</td>
                <td class="text-center">192.58</td>
                <td class="text-center Red">-1.55%</td>
                <td class="text-center">49,656,509</td>
              </tr>
              <tr>
                <td class="fw-5">AAPL</td>
                <td class="text-center">Apple Inc.</td>
                <td class="text-center">Consumer Electronics</td>
                <td class="text-center">Technology</td>
                <td class="text-center">USA</td>
                <td class="text-center">3.03T</td>
                <td class="text-center">192.58</td>
                <td class="text-center Red">-1.55%</td>
                <td class="text-center">49,656,509</td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
      <div class="tab-pane fade" id="pills-valuation" role="tabpanel" aria-labelledby="pills-valuation-tab"
        tabindex="0">
        <div class="overflow-auto screener-table-wapper">
          <table class="table screener-table-width border">
            <thead>
              <tr>
                <th class="fw-6">Ticker</th>
                <th class="text-center fw-6">Market Cap</th>
                <th class="text-center fw-6">P/E</th>
                <th class="text-center fw-6">Fwd P/E</th>
                <th class="text-center fw-6">PEG</th>
                <th class="text-center fw-6">P/B</th>
                <th class="text-center fw-6">EPS this Y</th>
                <th class="text-center fw-6">EPS next Y</th>
                <th class="text-center fw-6">EPS past 5Y</th>
                <th class="text-center fw-6">EPS next 5Y</th>
                <th class="text-center fw-6">Price</th>
                <th class="text-center fw-6">Change</th>
                <th class="text-center fw-6">Volume</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="fw-5">OFIX</td>
                <td class="text-center">711.15M</td>
                <td class="text-center">-</td>
                <td class="text-center">-29.04</td>
                <td class="text-center">-3.34</td>
                <td class="text-center">1.07</td>
                <td class="text-center">-4,500.00%</td>
                <td class="text-center">154.50%</td>
                <td class="text-center">-38.07%</td>
                <td class="text-center">9.40% </td>
                <td class="text-center">19.46</td>
                <td class="text-center Red">-1.82%</td>
                <td class="text-center">129,951</td>
              </tr>
              <tr>
                <td class="fw-5">OFIX</td>
                <td class="text-center">711.15M</td>
                <td class="text-center">-</td>
                <td class="text-center">-29.04</td>
                <td class="text-center">-3.34</td>
                <td class="text-center">1.07</td>
                <td class="text-center">-4,500.00%</td>
                <td class="text-center">154.50%</td>
                <td class="text-center">-38.07%</td>
                <td class="text-center">9.40% </td>
                <td class="text-center">19.46</td>
                <td class="text-center Red">-1.82%</td>
                <td class="text-center">129,951</td>
              </tr>
              <tr>
                <td class="fw-5">OFIX</td>
                <td class="text-center">711.15M</td>
                <td class="text-center">-</td>
                <td class="text-center">-29.04</td>
                <td class="text-center">-3.34</td>
                <td class="text-center">1.07</td>
                <td class="text-center">-4,500.00%</td>
                <td class="text-center">154.50%</td>
                <td class="text-center">-38.07%</td>
                <td class="text-center">9.40% </td>
                <td class="text-center">19.46</td>
                <td class="text-center Red">-1.82%</td>
                <td class="text-center">129,951</td>
              </tr>
              <tr>
                <td class="fw-5">OFIX</td>
                <td class="text-center">711.15M</td>
                <td class="text-center">-</td>
                <td class="text-center">-29.04</td>
                <td class="text-center">-3.34</td>
                <td class="text-center">1.07</td>
                <td class="text-center">-4,500.00%</td>
                <td class="text-center">154.50%</td>
                <td class="text-center">-38.07%</td>
                <td class="text-center">9.40% </td>
                <td class="text-center">19.46</td>
                <td class="text-center Red">-1.82%</td>
                <td class="text-center">129,951</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="pills-financial" role="tabpanel" aria-labelledby="pills-financial-tab"
        tabindex="0">
        <div class="overflow-auto screener-table-wapper">
          <table class="table screener-table-width border">
            <thead>
              <tr>
                <th class="fw-6">Ticker</th>
                <th class="text-center fw-6">Market Cap</th>
                <th class="text-center fw-6">Dividend</th>
                <th class="text-center fw-6">ROA</th>
                <th class="text-center fw-6">ROE</th>
                <th class="text-center fw-6">Curr R</th>
                <th class="text-center fw-6">Quick R</th>
                <th class="text-center fw-6">Debt/Eq</th>
                <th class="text-center fw-6">Gross M</th>
                <th class="text-center fw-6">Oper M</th>
                <th class="text-center fw-6">Profit M</th>
                <th class="text-center fw-6">Ernings</th>
                <th class="text-center fw-6">Price</th>
                <th class="text-center fw-6">Change</th>
                <th class="text-center fw-6">Volume</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">1.98M</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">1.65</td>
                <td class="text-center">1.40</td>
                <td class="text-center">-80.50</td>
                <td class="text-center">157.55%</td>
                <td class="text-center">64.85%</td>
                <td class="text-center">340.14%</td>
                <td class="text-center">-</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Green">0.00%</td>
                <td class="text-center">100</td>
              </tr>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">1.98M</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">1.65</td>
                <td class="text-center">1.40</td>
                <td class="text-center">-80.50</td>
                <td class="text-center">157.55%</td>
                <td class="text-center">64.85%</td>
                <td class="text-center">340.14%</td>
                <td class="text-center">-</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Green">0.00%</td>
                <td class="text-center">100</td>
              </tr>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">1.98M</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">1.65</td>
                <td class="text-center">1.40</td>
                <td class="text-center">-80.50</td>
                <td class="text-center">157.55%</td>
                <td class="text-center">64.85%</td>
                <td class="text-center">340.14%</td>
                <td class="text-center">-</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Green">0.00%</td>
                <td class="text-center">100</td>
              </tr>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">1.98M</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">1.65</td>
                <td class="text-center">1.40</td>
                <td class="text-center">-80.50</td>
                <td class="text-center">157.55%</td>
                <td class="text-center">64.85%</td>
                <td class="text-center">340.14%</td>
                <td class="text-center">-</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Green">0.00%</td>
                <td class="text-center">100</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="pills-ownership" role="tabpanel" aria-labelledby="pills-ownership-tab"
        tabindex="0">
        <div class="overflow-auto screener-table-wapper">
          <table class="table screener-table-width border">
            <thead>
              <tr>
                <th class="fw-6">Ticker</th>
                <th class="text-center fw-6">Market Cap</th>
                <th class="text-center fw-6">Outstanding</th>
                <th class="text-center fw-6">Float</th>
                <th class="text-center fw-6">Insider Own</th>
                <th class="text-center fw-6">Inst Own</th>
                <th class="text-center fw-6">Float Short</th>
                <th class="text-center fw-6">Short Ratio</th>
                <th class="text-center fw-6">Short this M</th>
                <th class="text-center fw-6">Short past M</th>
                <th class="text-center fw-6">Price</th>
                <th class="text-center fw-6">Change</th>
                <th class="text-center fw-6">Volume</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">1.98M</td>
                <td class="text-center">374.13M</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Red">-1.55%</td>
                <td class="text-center">49,656,509</td>
              </tr>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">1.98M</td>
                <td class="text-center">374.13M</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Red">-1.55%</td>
                <td class="text-center">49,656,509</td>
              </tr>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">1.98M</td>
                <td class="text-center">374.13M</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Red">-1.55%</td>
                <td class="text-center">49,656,509</td>
              </tr>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">1.98M</td>
                <td class="text-center">374.13M</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Red">-1.55%</td>
                <td class="text-center">49,656,509</td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
      <div class="tab-pane fade" id="pills-performance" role="tabpanel" aria-labelledby="pills-performance-tab"
        tabindex="0">
        <div class="overflow-auto screener-table-wapper">
          <table class="table screener-table-width border">
            <thead>
              <tr>
                <th class="fw-6">Ticker</th>
                <th class="text-center fw-6">Beta</th>
                <th class="text-center fw-6">Ern Qtrly Grth</th>
                <th class="text-center fw-6">50D Avg Chg</th>
                <th class="text-center fw-6">200D Avg Chg</th>
                <th class="text-center fw-6">52W High Chg</th>
                <th class="text-center fw-6">52W Low Chg</th>
                <th class="text-center fw-6">Recomm</th>
                <th class="text-center fw-6">Avg Volume</th>
                <th class="text-center fw-6">Price</th>
                <th class="text-center fw-6">Change</th>
                <th class="text-center fw-6">Volume</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">-0.43</td>
                <td class="text-center">-</td>
                <td class="text-center">-6.00%</td>
                <td class="text-center">-40.00%</td>
                <td class="text-center">-89.00%</td>
                <td class="text-center">212.00%</td>
                <td class="text-center">-</td>
                <td class="text-center">594.59K</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Green">0.00%</td>
                <td class="text-center">100</td>
              </tr>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">-0.43</td>
                <td class="text-center">-</td>
                <td class="text-center">-6.00%</td>
                <td class="text-center">-40.00%</td>
                <td class="text-center">-89.00%</td>
                <td class="text-center">212.00%</td>
                <td class="text-center">-</td>
                <td class="text-center">594.59K</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Green">0.00%</td>
                <td class="text-center">100</td>
              </tr>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">-0.43</td>
                <td class="text-center">-</td>
                <td class="text-center">-6.00%</td>
                <td class="text-center">-40.00%</td>
                <td class="text-center">-89.00%</td>
                <td class="text-center">212.00%</td>
                <td class="text-center">-</td>
                <td class="text-center">594.59K</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Green">0.00%</td>
                <td class="text-center">100</td>
              </tr>
              <tr>
                <td class="fw-5">NXMR</td>
                <td class="text-center">-0.43</td>
                <td class="text-center">-</td>
                <td class="text-center">-6.00%</td>
                <td class="text-center">-40.00%</td>
                <td class="text-center">-89.00%</td>
                <td class="text-center">212.00%</td>
                <td class="text-center">-</td>
                <td class="text-center">594.59K</td>
                <td class="text-center">0.00530</td>
                <td class="text-center Green">0.00%</td>
                <td class="text-center">100</td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>
</template>
<style>
.filter {
  row-gap: 16px !important;
  max-height: 50vh;
}

.filter-heading {
  width: 88px;
}

.filter-field-border {
  border: 1px solid #cbcaca;
}

.fiter-search-field {
  width: 200px;
}
.form-select-filter {
  width: 150px;
}

.screener-table-tabs-btn.active {
  background-color: var(--cta-btn) !important;
  border-radius: 0px;
}

.screener-table-width {
  min-width: 800px;
}

.screener-market-table-wapper::-webkit-scrollbar {
  height: 6px;
}
.indicators-checkbox-btn{
  --bs-btn-color: var(--cta-btn) !important;
  --bs-btn-active-bg: var(--cta-btn) !important;
  --bs-btn-border-color: var(--cta-btn) !important;
  --bs-btn-active-border-color: var(--cta-btn) !important;
}
.indicators-checkbox-btn:hover{
background-color: var(--cta-btn) !important;
color: var(--white) !important;
}
@media (max-width: 991px){
  .filter{
    justify-content: space-around !important
  }
  /* .select-filter-wrapper{
  justify-content: around !important;
} */
}
@media (max-width: 767px){
  .market-container{
    width: 720px !important;
  }
}
</style>