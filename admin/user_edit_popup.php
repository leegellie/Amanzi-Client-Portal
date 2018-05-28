        	<div class="span12">
                <div id="user-data" class="frame ">
                    <div class="notice marker-on-bottom bg-lightBlue" href="#"><h2 class="fg-white">Popup Will be moved later</h2></div>
                    <div id="user-block" class="content">
                        <form name="edit_user_data" id="user_data" action="#" class="AdvancedForm">
                            <table width="100%" style="background:none">
                                <tr>
                                    <td width="15%">
                                        <p>User Role:</p>
                                    </td>
                                    <td width="35%">
                                        <div id="user_typeDIV" class="input-control select" data-role="input-control">
                                            <select name="user_type" id="user_type" data-transform="input-control">
                                                <option value="0" selected>Select User Type</option> 
                                                <option value="0" disabled><h4>&nbsp;&nbsp;Internal Employees</h4></option>
                                    <!-- THE FOLLOWING PHP LOOPS THROUGH AND ECHOS INTERNAL "EMPLOYEE" USER ROLES -->
                                    <?
                                        $internal_user_roles = new user_action;
                                        $rows = $internal_role_rows = $internal_user_roles->get_user_roles("1","0");
                                        foreach ($rows as $row) {
                                            echo "<option value='$row[0]'>$row[2]</option>";
                                        }
                                    ?>
                                                <option value="0" disabled></option>
                                                <option value="0" disabled><h4>&nbsp;&nbsp;External Customers</h4></option>
                                    <?
                                        $internal_user_roles = new user_action;
                                        $rows = $internal_role_rows = $internal_user_roles->get_user_roles("0","1");
                                        foreach ($rows as $row) {
                                            echo "<option value='$row[0]'>$row[2]</option>";
                                        }
                                    ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td width="15%" style="padding-left:10px;">
                                        <p>Username: </p>
                                    </td>
                                    <td width="35%">
                                        <div id="usernameDIV" class="input-control text" data-role="input-control">
                                            <input name="username" id="username" type="text" value="" data-transform="input-control"> <span id="usernameError"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Password: </p>
                                    </td>
                                    <td>
                                        <div id="passwordDIV" class="input-control text" data-role="input-control">
                                            <input name="password" id="password" type="text" value="" data-transform="input-control">
                                        </div>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <p>Verify Password: </p>
                                    </td>
                                    <td>
                                        <div id="v_passwordDIV" class="input-control text" data-role="input-control">
                                                <input name="v_password" id="v_password" type="text" data-transform="input-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Contact Info:</h4>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>First Name: </p>
                                    </td>
                                    <td>
                                        <div id="fnameDIV" class="input-control text" data-role="input-control">
                                            <input name="fname" id="fname" value="" data-transform="input-control">
                                        </div>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <p>Last Name: </p>
                                    </td>
                                    <td>
                                        <div id="lnameDIV" class="input-control text" data-role="input-control">
                                            <input name="lname" id="lname" value="" data-transform="input-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Company: </p>
                                    </td>
                                    <td>
                                        <div id="companyDIV" class="input-control text" data-role="input-control">
                                            <input name="company" id="company" value="" data-transform="input-control">
                                        </div>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <p>Email: </p>
                                    </td>
                                    <td>
                                        <div id="emailDIV" class="input-control text" data-role="input-control">
                                            <input name="email" id="email" value="" data-transform="input-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Phone: </p>
                                    </td>
                                    <td>
                                        <div id="phoneDIV" class="input-control text" data-role="input-control">
                                            <input name="phone" id="phone" value="" data-transform="input-control" placeholder="Just number, no spaces or format">
                                        </div>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <p>Address:</p>
                                    </td>
                                    <td>
                                        <div id="address1DIV" class="input-control text" data-role="input-control">
                                            <input name="address1" id="address1" value="" data-transform="input-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <div id="address2DIV" class="input-control text" data-role="input-control">
                                            <input name="address2" id="address2" value="" placeholder="Optional" data-transform="input-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>City: </p>
                                    </td>
                                    <td>
                                        <div id="cityDIV" class="input-control text" data-role="input-control">
                                            <input name="city" id="city" value="" data-transform="input-control">
                                        </div>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <p>State: </p>
                                    </td>
                                    <td>
                                        <div id="stateDIV" class="input-control select" data-role="input-control">
                                            <select name="state" id="state" value="" data-transform="input-control">
                                                <option value="" selected>Choose a State</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <option value="AR">Arkansas</option>
                                                <option value="CA">California</option>
                                                <option value="CO">Colorado</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="DC">District Of Columbia</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="ID">Idaho</option>
                                                <option value="IL">Illinois</option>
                                                <option value="IN">Indiana</option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">Kansas</option>
                                                <option value="KY">Kentucky</option>
                                                <option value="LA">Louisiana</option>
                                                <option value="ME">Maine</option>
                                                <option value="MD">Maryland</option>
                                                <option value="MA">Massachusetts</option>
                                                <option value="MI">Michigan</option>
                                                <option value="MN">Minnesota</option>
                                                <option value="MS">Mississippi</option>
                                                <option value="MO">Missouri</option>
                                                <option value="MT">Montana</option>
                                                <option value="NE">Nebraska</option>
                                                <option value="NV">Nevada</option>
                                                <option value="NH">New Hampshire</option>
                                                <option value="NJ">New Jersey</option>
                                                <option value="NM">New Mexico</option>
                                                <option value="NY">New York</option>
                                                <option value="NC">North Carolina</option>
                                                <option value="ND">North Dakota</option>
                                                <option value="OH">Ohio</option>
                                                <option value="OK">Oklahoma</option>
                                                <option value="OR">Oregon</option>
                                                <option value="PA">Pennsylvania</option>
                                                <option value="RI">Rhode Island</option>
                                                <option value="SC">South Carolina</option>
                                                <option value="SD">South Dakota</option>
                                                <option value="TN">Tennessee</option>
                                                <option value="TX">Texas</option>
                                                <option value="UT">Utah</option>
                                                <option value="VT">Vermont</option>
                                                <option value="VA">Virginia</option>
                                                <option value="WA">Washington</option>
                                                <option value="WV">West Virginia</option>
                                                <option value="WI">Wisconsin</option>
                                                <option value="WY">Wyoming</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Zip: </p>
                                    </td>
                                    <td>
                                        <div id="zipDIV" class="input-control text" data-role="input-control">
                                            <input name="zip" id="zip" value="" data-transform="input-control">
                                        </div>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <input name="action" id="action" type="hidden" value="add_user_data" />
                                        <input name="submit" class="bg-yellow" id="FormSubmit" type="submit" value="Continue" data-transform="input-control" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <div id="user-billing" class="frame">
                    <a class="notice marker-on-bottom heading bg-lightBlue collapsed" href="#"><h2 class="fg-white">Billing Information:</h2></a>
                    <div id="billing-block" class="content clearfix">
                        <form name="user_billing" id="user_billing" action="#">
                            <table width="100%" style="background:none">
                                <tr>
                                    <td width="30%">
                                        <p style="font-weight:bold">Same as User Account?</p>
                                    </td>
                                    <td width="70%">
                                        <div style="display:inline-block" class="input-control switch margin10" data-role="input-control">
                                            <label style="display:inline-block">
                                                Yes / No:&nbsp;&nbsp;&nbsp;&nbsp; <input style="display:inline-block" id="sameAdd" name="sameAdd" type="checkbox" value="sameAs" data-transform="input-control" data-transform-type="switch" onChange="autoFillBilling()" checked="checked" >
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Name: </p>
                                    </td>
                                    <td>
                                        <div id="billing_fnameDIV" class="input-control text" data-role="input-control">
                                            <input name="billing_name" id="billing_name" value="" data-transform="input-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Company: </p>
                                    </td>
                                    <td>
                                        <div id="billing_companyDIV" class="input-control text" data-role="input-control">
                                            <input name="billing_company" id="billing_company" value="" data-transform="input-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Address: </p>
                                    </td>
                                    <td>
                                        <div id="billing_address1DIV" class="input-control text" data-role="input-control">
                                        <input name="billing_address1" id="billing_address1" value="" data-transform="input-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <div id="billing_address2DIV" class="input-control text" data-role="input-control">
                                            <input name="billing_address2" id="billing_address2" placeholder="Optional" value="" data-transform="input-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>City: </p>
                                    </td>
                                    <td>
                                        <div id="billing_cityDIV" class="input-control text" data-role="input-control">
                                            <input name="billing_city" id="billing_city" value="" data-transform="input-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>State: </p>
                                    </td>
                                    <td>
                                        <div id="billing_stateDIV" class="input-control select" data-role="input-control">
                                            <select name="billing_state" id="billing_state" value="" data-transform="input-control">
                                                <option value="" selected>Choose a State</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <option value="AR">Arkansas</option>
                                                <option value="CA">California</option>
                                                <option value="CO">Colorado</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="DC">District Of Columbia</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="ID">Idaho</option>
                                                <option value="IL">Illinois</option>
                                                <option value="IN">Indiana</option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">Kansas</option>
                                                <option value="KY">Kentucky</option>
                                                <option value="LA">Louisiana</option>
                                                <option value="ME">Maine</option>
                                                <option value="MD">Maryland</option>
                                                <option value="MA">Massachusetts</option>
                                                <option value="MI">Michigan</option>
                                                <option value="MN">Minnesota</option>
                                                <option value="MS">Mississippi</option>
                                                <option value="MO">Missouri</option>
                                                <option value="MT">Montana</option>
                                                <option value="NE">Nebraska</option>
                                                <option value="NV">Nevada</option>
                                                <option value="NH">New Hampshire</option>
                                                <option value="NJ">New Jersey</option>
                                                <option value="NM">New Mexico</option>
                                                <option value="NY">New York</option>
                                                <option value="NC">North Carolina</option>
                                                <option value="ND">North Dakota</option>
                                                <option value="OH">Ohio</option>
                                                <option value="OK">Oklahoma</option>
                                                <option value="OR">Oregon</option>
                                                <option value="PA">Pennsylvania</option>
                                                <option value="RI">Rhode Island</option>
                                                <option value="SC">South Carolina</option>
                                                <option value="SD">South Dakota</option>
                                                <option value="TN">Tennessee</option>
                                                <option value="TX">Texas</option>
                                                <option value="UT">Utah</option>
                                                <option value="VT">Vermont</option>
                                                <option value="VA">Virginia</option>
                                                <option value="WA">Washington</option>
                                                <option value="WV">West Virginia</option>
                                                <option value="WI">Wisconsin</option>
                                                <option value="WY">Wyoming</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Zip: </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div id="billing_zipDIV" class="input-control text" data-role="input-control">
                                            <input name="billing_zip" id="billing_zip" value="" data-transform="input-control" />
                                        </div>
                                        <input name="uid" id="uid" type="hidden" value="">
                                    </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input name="action" id="action" type="hidden" value="add_user_billing" />
                                        <input name="submit" class="bg-yellow" id="BillingSubmit" type="submit" value="Add Billing Data" data-transform="input-control" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>