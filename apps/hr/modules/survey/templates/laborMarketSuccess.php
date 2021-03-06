<!-- SELECT employee_no, name, commence_date, date_resigned FROM `hr_employee` WHERE  -->
<!-- (commence_date >= '2015-03-01' && commence_date <= '2015-03-31') -->
<!-- or -->
<!-- (date_resigned >= '2015-03-01' && date_resigned <= '2015-03-31') -->
<?php use_helper('Validation', 'Javascript') ?>
<form name="FORMadd" id="IDFORMadd" action="<?php echo url_for('survey/laborMarket') ?>" method="post">

<div class="contentBox">
	<table class="table bordered condensed">
	<tr>
	    <td colspan="2" class="alignLeft"><h2>LABOUR MARKET SURVEY</h2></td>
	</tr>
	
	<tr>
	    <td class="bg-clearBlue alignRight" nowrap><label>FROM</label></td>
	    <td class="FORMcell-right" nowrap>
	    <?php
	    echo HTMLLib::CreateDateInput('labour_survey_sdate', $sf_params->get('labour_survey_sdate'), 'span2');
	    //echo HTMLForm::DrawDateInput('labour_survey_sdate', $sf_params->get('labour_survey_sdate'), XIDX::next(), XIDX::next(), 'size="15"');
	    ?>
	    </td>    
	</tr>
	<tr>
	    <td class="bg-clearBlue alignRight" nowrap><label>TO</label></td>
	    <td class="FORMcell-right" nowrap>
	    <?php	
	    	echo HTMLLib::CreateDateInput('labour_survey_edate', $sf_params->get('labour_survey_edate'), 'span2');    
	    	//echo HTMLForm::DrawDateInput('labour_survey_edate', $sf_params->get('labour_survey_edate'), XIDX::next(), XIDX::next(), 'size="15"');
	    ?>
	    </td>    
	</tr>
	
	<tr>
	    <td class="bg-clearBlue alignRight" nowrap></td>
	    <td class="FORMcell-right" nowrap>
	       <input type="submit" name="printLabourMarketSurvey" value=" Print Labour Market Survey " class="success">
	    </td>
	</tr>
	
	<tr>
	</tr>
	</table>
	
	<div class="panel" data-role="panel">
    <div class="bg-blue fg-white panel-header">
        EMPLOYEE LIST
    </div>
    <div class="panel-content">
        <table class="table bordered condensed">
        <th class="bg-clearBlue"><small>Type</small></th>
        <th class="bg-clearBlue"><small>Seq</small></th>
        <th class="bg-clearBlue"><small>Employee No</small></th>
        <th class="bg-clearBlue"><small>Name</small></th>
        <th class="bg-clearBlue"><small>Commence Date</small></th>
        <th class="bg-clearBlue"><small>Resigned Date</small></th>
        <th class="bg-clearBlue"><small>Profession</small></th>
        
        <!--  FULL TIME WORKER LIST -->
        <?php $seq = 1; ?>
        <?php foreach($surveyPaidStart['list']['fulltime'] as $name): ?>
        <?php $empData = HrEmployeePeer::GetDatabyName($name); ?>
        <?php 
        	$commenceClass = '';
        	$resignedClass = '';
        	$commenceDate = '';
        	$resignedDate = '';
        	if ( $empData->getCommenceDate() >= $sf_params->get('labour_survey_sdate') && $empData->getCommenceDate() <= $sf_params->get('labour_survey_edate')):
        		$commenceClass = 'fg-white bg-blue';
        		$commenceDate = $empData->getCommenceDate();
        	endif;
        	if ( $empData->getDateResigned() >= $sf_params->get('labour_survey_sdate') && $empData->getDateResigned() <= $sf_params->get('labour_survey_edate')):
        		$resignedClass = 'fg-white bg-red';
        		$resignedDate = $empData->getDateResigned();
        	endif;
        ?>
        <tr>
        	<td><small>Fulltime</small></td>
        	<td><small><?php echo $seq++ ?></small></td>
        	<td><small><?php echo $empData->getEmployeeNo() ?></small></td>
        	<td><small><?php echo $name ?></small></td>
        	<td class="<?php echo $commenceClass ?>"><small><?php echo $commenceDate ?></small></td>
        	<td class="<?php echo $resignedClass ?>"><small><?php echo $resignedDate ?></small></td>
        	<td><small><?php echo $empData->getProfession() ?></small></td>
        </tr>
        <?php endforeach; ?>
        
        <!--  PART TIME WORKER LIST -->
        <?php //$seq = 1; ?>
        <?php foreach($surveyPaidStart['list']['parttime'] as $name): ?>
        <?php $empData = HrEmployeePeer::GetDatabyName($name); ?>
        <?php 
        	$commenceClass = '';
        	$resignedClass = '';
        	$commenceDate = '';
        	$resignedDate = '';
        	if ( $empData->getCommenceDate() >= $sf_params->get('labour_survey_sdate') && $empData->getCommenceDate() <= $sf_params->get('labour_survey_edate')):
        		$commenceClass = 'fg-white bg-blue';
        		$commenceDate = $empData->getCommenceDate();
        	endif;
        	if ( $empData->getDateResigned() >= $sf_params->get('labour_survey_sdate') && $empData->getDateResigned() <= $sf_params->get('labour_survey_edate')):
        		$resignedClass = 'fg-white bg-red';
        		$resignedDate = $empData->getDateResigned();
        	endif;
        ?>
        <tr>
        	<td><small>Parttime</small></td>
        	<td><small><?php echo $seq++ ?></small></td>
        	<td><small><?php echo $empData->getEmployeeNo() ?></small></td>
        	<td><small><?php echo $name ?></small></td>
        	<td class="<?php echo $commenceClass ?>"><small><?php echo $commenceDate ?></small></td>
        	<td class="<?php echo $resignedClass ?>"><small><?php echo $resignedDate ?></small></td>
        	<td><small><?php echo $empData->getProfession() ?></small></td>
        </tr>
        <?php endforeach; ?>
        	
        </table>
    </div>
	</div>
	<br>
	<?php 
	if ($showSurvey):
		include_partial('labor_market', array('surveyPaidStart'=> $surveyPaidStart, 'surveyNew'=>$surveyNew, 'surveyResigned'=>$surveyResigned, 'surveyOT'=>$surveyOT) );
	endif;
	?>
</div>
</form>