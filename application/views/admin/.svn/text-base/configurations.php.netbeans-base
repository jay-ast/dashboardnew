<article class="module width_half">
<form method="post" action="<?= site_url("admin/configurations/save_site")?>">
	<header>
		<h3 class="tabs_involved">Site Options</h3>
		<div class="submit_link">
			<input type="submit" value="Save Options" class="alt_btn">
		</div>
	</header>

	<table cellspacing="0" class="tablesorter"> 
		<tbody> 
			<tr class='editRow'>
				<td>
					Site Title:
					<input type="hidden" name="name[]" value="SITE_TITLE">
				</td>
				<td>
					<input type="text" name="value[]" value="<?= SITE_TITLE?>" style="width: 90%">
				</td>
			</tr> 
			
			<tr class='editRow'>
				<td>
					Contact Email:
					<input type="hidden" name="name[]" value="CONTACT_EMAIL">
				</td>
				<td>
					<input type="text" name="value[]" value="<?= CONTACT_EMAIL?>" style="width: 90%">
				</td>
			</tr>
			
			<tr class='editRow'>
				<td>
					iPhone APP URL:
					<input type="hidden" name="name[]" value="IPHONE_APP_URL">
				</td>
				<td>
					<input type="text" name="value[]" value="<?= IPHONE_APP_URL?>" style="width: 90%">
				</td>
			</tr>
			
			<tr class='editRow'>
				<td>
					Android APP URL:
					<input type="hidden" name="name[]" value="ANDROID_APP_URL">
				</td>
				<td>
					<input type="text" name="value[]" value="<?= ANDROID_APP_URL?>" style="width: 90%">
				</td>
			</tr>
			
			<tr class='editRow'>
				<td>
					Facebook URL:
					<input type="hidden" name="name[]" value="FACEBOOK_LINK">
				</td>
				<td>
					<input type="text" name="value[]" value="<?= FACEBOOK_LINK?>" style="width: 90%">
				</td>
			</tr>
			
			<tr class='editRow'>
				<td>
					Twitter URL:
					<input type="hidden" name="name[]" value="TWITTER_LINK">
				</td>
				<td>
					<input type="text" name="value[]" value="<?= TWITTER_LINK?>" style="width: 90%">
				</td>
			</tr>
		</tbody> 
	</table>
	
	<footer>
		<div class="submit_link">
			<input type="submit" value="Save Options" class="alt_btn">
		</div>
	</footer>
</form>
</article>

<article class="module width_half">
<form method="post" action="<?= site_url("admin/configurations/save_paypal")?>">
	<header>
		<h3 class="tabs_involved">Payment Options</h3>
		<div class="submit_link">
			<input type="submit" value="Save Options" class="alt_btn">
		</div>
	</header>

	<table cellspacing="0" class="tablesorter"> 
		<tbody> 
			<tr class='editRow'>
				<td>
					Payment Type:
					<input type="hidden" name="name[]" value="PAYMENT_SANDBOX">
				</td>
				<td>
					<select name="value[]">
						<option value="production" <?php if ( PAYMENT_SANDBOX == 'production' ) echo "selected"?>>Production Account</option>
						<option value="sandbox" <?php if ( PAYMENT_SANDBOX == 'sandbox' ) echo "selected"?>>Sandbox Account</option>
					</select>
				</td>
			</tr> 
			
			<tr class='editRow'>
				<td>
					Merchant Account:
					<input type="hidden" name="name[]" value="PAYMENT_MERCHANT_ID">
				</td>
				<td>
					<input type="text" name="value[]" value="<?=PAYMENT_MERCHANT_ID?>" style="width: 90%">
				</td>
			</tr>
			
			<tr class='editRow'>
				<td>
					Public Key:
					<input type="hidden" name="name[]" value="PAYMENT_PUBLIC_KEY">
				</td>
				<td>
					<input type="text" name="value[]" value="<?= PAYMENT_PUBLIC_KEY?>" style="width: 90%">
				</td>
			</tr>
			
			<tr class='editRow'>
				<td>
					Private Key:
					<input type="hidden" name="name[]" value="PAYMENT_PRIVATE_KEY">
				</td>
				<td>
					<input type="text" name="value[]" value="<?= PAYMENT_PRIVATE_KEY?>" style="width: 90%">
				</td>
			</tr>
                        
                        <tr class='editRow'>
				<td>
					Merchant Id:
					<input type="hidden" name="name[]" value="MERCHANT_ID">
				</td>
				<td>
					<select name="value[]">
						<option value="DoggyBnB_marketplace" <?php if ( MERCHANT_ID == 'DoggyBnB_marketplace' ) echo "selected"?>>DoggyBnB_marketplace (Production)</option>
						<option value="rmjg8vkm3zzbg76g" <?php if ( MERCHANT_ID == 'rmjg8vkm3zzbg76g' ) echo "selected"?>>rmjg8vkm3zzbg76g (Sandbox)</option>
					</select>
				</td>
			</tr>
			
			<tr class='editRow'>
				<td>
					Currency Code:
					<input type="hidden" name="name[]" value="CURRENCY_CODE">
				</td>
				<td>
					<select name="value[]">						
						<option value="US" <?php if ( CURRENCY_CODE == 'US' ) echo "selected"?>>USD (United State)</option>
					</select>
				</td>
			</tr>
                        
                       <tr class='editRow'>
				<td>
					Cancel / Exp. Fees:
					<input type="hidden" name="name[]" value="CHARGE_FEES">
				</td>
				<td>
					<select name="value[]">
						<option value="NO" <?php if ( CHARGE_FEES == 'NO' ) echo "selected"?>>Don't Charge Fees </option>
						<option value="YES" <?php if ( CHARGE_FEES == 'YES' ) echo "selected"?>>Charge Fees</option>
					</select>
				</td>
			</tr> 
		</tbody> 
	</table>
	
	<footer>
		<div class="submit_link">
			<input type="submit" value="Save Options" class="alt_btn">
		</div>
	</footer>
</form>
</article>