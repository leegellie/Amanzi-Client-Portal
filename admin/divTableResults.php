          
          
		{company:<?= substr($results['company'],0,15); ?>,
        username:<?= substr($results['username'],0,15); ?>,
        email:<?= substr($results['email'],0,15); ?>,
        fname:<?= substr($results['fname'],0,15); ?>,
        lname:<?= substr($results['lname'],0,15); ?>,
        edit:"<input id="editUser" type="submit" class="bg-yellow" value="Edit" onClick="editThisUser(<?= substr($results['username'],0,15); ?>)" />"}#


		<div class="wrapper_results" style="margin-left:0">
            <div id="company_results" class="result_list" title="<?= $results['company']; ?>">
            	<?= substr($results['company'],0,15); ?>&nbsp;
            </div>
            <div id="username_results" class="result_list" title="<?= $results['username']; ?>">
            	<?= substr($results['username'],0,15); ?>&nbsp;
            </div>
            <div id="email_results" class="result_list" title="<?= $results['email']; ?>">
            	<?= substr($results['email'],0,15); ?>&nbsp;
            </div>
            <div id="fname_results" class="result_list" title="<?= $results['fname']; ?>">
				<?= substr($results['fname'],0,15); ?>&nbsp;
            </div>
            <div id="lname_results" class="result_list" title="<?= $results['lname']; ?>">
            	<?= substr($results['lname'],0,15); ?>&nbsp;
            </div>
            <div id="edit_results" class="result_list" title="" style="display:inline-block">
            	<a id="editUser" onClick="editThisUser(<?= substr($results['username'],0,15); ?>)" style="cursor:pointer" >Edit</a>
            </div>
          </div>#