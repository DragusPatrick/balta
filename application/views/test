<div class="reserve">
    <h2> Formular de rezervare </h2>

    <div id="step1" class="step">
        <div class="step-body">
            <p> Pe parcursul serviciului oferit doriti si cazare ? </p>

            <!-- Pas 1 -->
            <div id="verificare_cazare">
                <div class="radio radio-inline">
                    <label><input type="radio" name="cazare" value="1">Da, doresc si cazare</label>
                </div>
                <div class="radio radio-inline">
                    <label><input type="radio" value="0" name="cazare">Nu</label>
                </div>
            </div>

            <!-- Pas 2 daca vrea cazare -->
            <div id="tip_cazare" class="">
                <div class="table-responsive">
                    <label for="sel1">Selecteaza tipul de casa dorit:</label>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Tip Casa</th>
                            <th>Duminica-Joi</th>
                            <th>Vineri-Sambata</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="radio" name="tip_cazare" value="1"> Casuta Mica</td>
                            <td>120 lei</td>
                            <td>160 lei</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="tip_cazare" value="2"> Casute medii</td>
                            <td>140 lei</td>
                            <td>180 lei</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="tip_cazare" value="3"> Casute Mari</td>
                            <td>160 lei</td>
                            <td>200 lei</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pas 2 fara cazare -->
            <div id="tip_program" class="">
                <div class="form-group text-left mt20">
                    <label for="sel1">Selecteaza numarul de ore pentru care se face rezervarea:</label>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nr Ore</th>
                            <th>Interval</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="radio" name="tip_program" value="1"> 12h</td>
                            <td>Pescuit zi -> 06:00 - 18:00 | Pescuit noapte -> 18:00 - 06:00</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="tip_program" value="2"> 24h</td>
                            <td>Pescuit 24h -> 18:00 - 18:00</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pas 3 daca vrea cazare -->
            <div id="selectare_perioada" class="disable">
                <div class="form-group">
                    <h4 class="text-left">Start Date</h4>

                    <div class='input-group date'>
                        <input type='date' id='date_start'
                               name="data_s" class="form-control"
                               value="<?php echo date('Y-m-d'); ?>"/>
						    <span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
							</span>
                    </div>
                </div>
                <div class="form-group">
                    <h4 class="text-left">End Date</h4>

                    <div class='input-group date'>
                        <input type='date' id='date_end' name="data_e" class="form-control"
                               value="<?php echo date('Y-m-d'); ?>"/>
						    <span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
							</span>
                    </div>
                </div>
                <div id="dataError disable">
                    <p> Va rugam selectati date valide.</p>
                </div>
            </div>

        </div>
        <div class="step-footer">
            <button onclick="" class="btn btn-info">Inapoi</button>
            <button onclick="" class="btn btn-primary">Next</button>
        </div>
    </div>
</div>