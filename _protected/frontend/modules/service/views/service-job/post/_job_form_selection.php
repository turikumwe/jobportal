<p class="pxp-text-light">Select job type.</p>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <div class="form-group field-servicejob-s_opportunity_id required has-error">
                <label class="control-label" for="servicejob-s_opportunity_id">Opportunity job form type</label>
                <select id="form_type" class="form-control" aria-required="true" aria-invalid="true">
                    <option value="">Select job form Type</option>
                    <option value="1">Standard job form</option>
                    <option value="2">Job from other source form</option>
                </select>
            </div>            
        </div>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <div class="form-group">
                <button type="submit" class="btn btn-success" onclick="go_to_selected_form()">Continue</button>                
            </div>
        </div>
    </div>
</div>
<h2 style="margin-bottom: 0px;">About the forms</h2>
<span style="font-size: 25px; font-weight: bold;"><u>Standard job form:</u></span>
<span>This the form to post jobs which will require applicant to apply through Kora platform. It has all details to provide all details a about the Job</span><br />
<span style="font-size: 25px; font-weight: bold;"><u>Job from other source form:</u></span>
<span>This the form to post jobs from external platforms. It requires the job application link which job seekers shall use for application submission</span>