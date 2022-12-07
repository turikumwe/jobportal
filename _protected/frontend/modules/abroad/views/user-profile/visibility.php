<?php if(!isset($_GET['employer'])) { ?>
					<div class="panel widget light-widget panel-bd-top">
			            <div class="panel-heading"><?= Yii::t("frontend","Employers can see") ?></div>
			            <div class="panel-body">
			            	<table class="table">
			            		<tr>
								<td><b>Summary</b></td>
								<td>
									<a href="#" onClick="hideAndShowSummary()"class="mgbt-xs-15 font-semibold pull-right">
										<input 
											type="checkbox" 
											id="input_summary" 
											value="<?= ($jobseeker->userProfile->show_profile_summary) ? 0 : 1?>" 
											<?= ($jobseeker->userProfile->show_profile_summary) ? 'checked' : ''?>
										>
									</a>
								</td>
								</tr>

								<tr>
								<td><b>Skills</b></td>
								<td>
									<a href="#" onClick="hideAndShowSkill()"class="mgbt-xs-15 font-semibold pull-right">
										<input 
											type="checkbox" 
											id="input_skill" 
											value="<?= ($jobseeker->userProfile->show_skill) ? 0 : 1?>" 
											<?= ($jobseeker->userProfile->show_skill) ? 'checked' : ''?>
										>
									</a>
								</td>
								</tr>

								<tr>
								<td><b>Address</b></td>
								<td>
									<a href="#" onClick="hideAndShowAddress()"class="mgbt-xs-15 font-semibold pull-right">
										<input 
											type="checkbox" 
											id="input_address" 
											value="<?= ($jobseeker->userProfile->show_contact) ? 0 : 1?>" 
											<?= ($jobseeker->userProfile->show_contact) ? 'checked' : ''?>
										>
									</a>
								</td>
								</tr>

								<tr>
								<td><b>Training</b></td>
								<td>
									<a href="#" onClick="hideAndShowTraining()"class="mgbt-xs-15 font-semibold pull-right">
										<input 
											type="checkbox" 
											id="input_training" 
											value="<?= ($jobseeker->userProfile->show_training) ? 0 : 1?>" 
											<?= ($jobseeker->userProfile->show_training) ? 'checked' : ''?>
										>
									</a>
								</td>
								</tr>

								<tr>
								<td><b>Education</b></td>
								<td>
									<a href="#" onClick="hideAndShowEducation()"class="mgbt-xs-15 font-semibold pull-right">
										<input 
											type="checkbox" 
											id="input_education" 
											value="<?= ($jobseeker->userProfile->show_education) ? 0 : 1?>" 
											<?= ($jobseeker->userProfile->show_education) ? 'checked' : ''?>
										>
									</a>
								</td>
								</tr>

								<tr>
								<td><b>Language</b></td>				
								<td>
									<a href="#" onClick="hideAndShowLangage()" class="mgbt-xs-15 font-semibold pull-right">
									<input 
										type="checkbox" 
										id="input_language" 
										value="<?= ($jobseeker->userProfile->show_language) ? 0 : 1?>" 
										<?= ($jobseeker->userProfile->show_language) ? 'checked' : ''?>
									>
								</a>
								</td>
								</tr>

								<tr>
								<td><b>Driving license</b></td>
								<td>
									<a href="#" onClick="hideAndShowLicense()"class="mgbt-xs-15 font-semibold pull-right">
										<input 
											type="checkbox" 
											id="input_license" 
											value="<?= ($jobseeker->userProfile->show_drivinglicense) ? 0 : 1?>" 
											<?= ($jobseeker->userProfile->show_drivinglicense) ? 'checked' : ''?>
										>
									</a>
								</td>
								</tr>

								<tr>
								<td><b>Endorsement</b></td>
								<td>
									<a href="#" onClick="hideAndShowEndorse()"class="mgbt-xs-15 font-semibold pull-right">
										<input 
											type="checkbox" 
											id="input_endorse" 
											value="<?= ($jobseeker->userProfile->show_endorsement) ? 0 : 1?>" 
											<?= ($jobseeker->userProfile->show_endorsement) ? 'checked' : ''?>
										>
									</a>
								</td>
								</tr>

								<tr>
								<td><b>Recommandetion</b></td>
								<td>
									<a href="#" onClick="hideAndShowRecommandation()"class="mgbt-xs-15 font-semibold pull-right">
									<input 
										type="checkbox" 
										id="input_recommandation" 
										value="<?= ($jobseeker->userProfile->show_recommendation) ? 0 : 1?>" 
										<?= ($jobseeker->userProfile->show_recommendation) ? 'checked' : ''?>
									>
								</a>
								</td>
								</tr>

								<tr>
								<td><b>Professional Experience</b></td>
								<td>
									<a href="#" onClick="hideAndShowExperience()"class="mgbt-xs-15 font-semibold pull-right">
										<input 
											type="checkbox" 
											id="input_experience" 
											value="<?= ($jobseeker->userProfile->show_experience) ? 0 : 1?>" 
											<?= ($jobseeker->userProfile->show_experience) ? 'checked' : ''?>
										>
									</a>									
								</td>
								</tr>
						</table>
					</div>
				</div>
			<?php } ?>