<div class="container-fluid">
    <div class="row">
        <!-- Disease Probability Gauge -->
        <div class="col-md-3 mb-4">
            <div class="chart-card">
                <div class="card-body">
                    <h6 class="chart-title">Disease Probability Gauge</h6>
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
                    <div class="mt-3">
                        <label class="form-label">Select Condition</label>
                        <select id="disease_selector" class="form-control select2">
                            <option value="">Select Condition for Probability</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 1: Priority Disease Chart -->
        <div class="col-md-3 mb-4">
            <div class="chart-card">
                <div class="card-body">
                    <h6 class="chart-title">Diseases by Thematic Area</h6>
                    <div id="priority-disease-chart" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <!-- Chart 2: Priority Probability Chart -->
        <div class="col-md-3 mb-4">
            <div class="chart-card">
                <div class="card-body">
                    <h6 class="chart-title">Priority Probability Ranking</h6>
                    <div id="priority-probability-chart" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>

        <!-- Chart 3: Continental Disease Chart -->
        <div class="col-md-3 mb-4">
            <div class="chart-card">
                <div class="card-body">
                    <h6 class="chart-title">Continental Overview</h6>
                    <div id="continental-disease-chart" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
  