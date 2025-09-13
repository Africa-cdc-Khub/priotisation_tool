<div class="container-fluid">
    <div class="row no-gutters">
    <div class="col-md-3 p-2">
  <div class="card">
    <div class="card-body">
      <div id="disease-probability-gauge" style="height: 275px;"></div>

      <!-- Legend / Key -->
      <div class="mt-3 text-center">
        <strong>Priority Key:</strong>
        <div class="d-flex justify-content-around align-items-center mt-2">
        <span style="color: #28a745;">&#9632; Low</span>    
        <span style="color: #ffc107;">&#9632; Medium</span>  
        <span style="color: #dc3545;">&#9632; High</span>    

        </div>
      </div>

    <!-- Disease Selector -->

      <select id="disease_selector" class="form-control select2 mt-3">
        <option value="">Select Condition for Probability</option>
      </select>


      
    </div>
  </div>
</div>

      <!-- Chart 1 -->
      <div class="col-md-3 p-2">
        <div class="card">
          <div class="card-body">
            <div id="priority-disease-chart" style="height: 400px;"></div>
          </div>
        </div>
      </div>

      <!-- Chart 2 -->
      <div class="col-md-3 p-2">
        <div class="card">
         
          <div class="card-body">
          <div id="priority-probability-chart" style="height: 400px; width: 100%;"></div>

          </div>
        </div>
      </div>

      <!-- Chart 3 -->
      <div class="col-md-3 p-2">
        <div class="card">
          <div class="card-body">
            <div id="continental-disease-chart" style="height: 400px;"></div>
          </div>
        </div>
      </div>

    </div>
  </div>
  