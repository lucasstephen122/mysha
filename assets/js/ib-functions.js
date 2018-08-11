function get_status_text(status)
{
	switch(parseInt(status))
	{
		case  0 : return 'Draft';
		case 10 : return 'Draft';
		case 20 : return 'Submitted';
		case 30 : return 'Approved';
		case 40 : return 'Denied';
		case 50 : return 'Published';
		case 60 : return 'Inactive';
		case 70 : return 'Active';
		case 120 : return 'Awaiting';
		case 130 : return 'Confirmed';
		case 140 : return 'Received';
		case 150 : return 'Skipped';
		case 160 : return 'Assigned';
		case 170 : return 'Transferred';
		case 180 : return 'Cancelled';
		case 190 : return 'Consumed';
	}
}

function get_status_class(status)
{
	switch(parseInt(status))
	{
		case  0 : return 'default';
		case 10 : return 'default';
		case 20 : return 'primary';
		case 30 : return 'success';
		case 40 : return 'danger';
		case 50 : return 'info';
		case 60 : return 'inverse';
		case 70 : return 'success';
		case 120 : return 'warning';
		case 130 : return 'success';
		case 140 : return 'warning';
		case 150 : return 'inverse';
		case 160 : return 'danger';
		case 170 : return 'warning';
		case 180 : return 'danger';
		case 190 : return 'default';
	}
}

function get_render_url(attachment_id)
{
	return g.base_url + 'common/attachment/render/'+attachment_id;
}

function get_download_url(attachment_id)
{
	return g.base_url + 'common/attachment/download/'+attachment_id;
}

function get_alert_url(url)
{
	if(!url)
	{
		return '#';
	}

	if (url.indexOf("http://")==0 || url.indexOf("https://")==0)
	{
		return url;
	}
	else
	{
		return g.base_url+url;
	}
}

function get_owner_class(owner , viewer , status)
{
	switch(viewer)
	{
		case 'clinic' :
			switch(owner)
			{
				case '':
					return get_status_class(status);
				case 'clinic' :
					return get_status_class(status);
				case 'pharmacy' :
					return 'info';
				case 'insurance' :
					return 'info';
			}
			break;
		case 'pharmacy' :
			switch(owner)
			{
				case '':
					return get_status_class(status);
				case 'clinic' :
					return get_status_class(status);
				case 'pharmacy' :
					return get_status_class(status);
				case 'insurance' :
					return 'info';
			}
			break;
		case 'insurance' :
			switch(owner)
			{
				case '':
					return get_status_class(status);
				case 'clinic' :
					return get_status_class(status);
				case 'pharmacy' :
					return get_status_class(status);
				case 'insurance' :
					return get_status_class(status);
			}
			break;
	}
}


function get_encounter_status_text(status)
{
	switch(parseInt(status))
	{
		case  0 : return 'Pending';
		case 10 : return 'Pending';
		case 30 : return 'Approved';
		case 40 : return 'Denied';
		case 120 : return 'Awaiting';
		case 130 : return 'Confirmed';
		case 140 : return 'Received';
		default : return 'Received';
	}
}

function get_owner_text(owner , viewer , status)
{
	switch(viewer)
	{
		case 'clinic' :
			switch(owner)
			{
				case '':
					return get_status_text(status);
				case 'clinic' :
					return get_encounter_status_text(status);
				case 'pharmacy' :
					return 'With Pharmacy';
				case 'insurance' :
					return 'With Insurance';
			}
			break;
		case 'pharmacy' :
			switch(owner)
			{
				case '':
					return get_status_text(status);
				case 'clinic' :
					return get_status_text(status);
				case 'pharmacy' :
					return get_encounter_status_text(status);
				case 'insurance' :
					return 'With Insurance';
			}
			break;
		case 'insurance' :
			switch(owner)
			{
				case '':
					return get_status_text(status);
				case 'clinic' :
					return get_status_text(status);
				case 'pharmacy' :
					return get_status_text(status);
				case 'insurance' :
					return get_encounter_status_text(status);
			}
			break;
	}
}


function get_entity_type(owner)
{
	switch(owner)
	{
		case 'clinic': return 'Office'; break;
		case 'pharmacy': return 'Specialty Pharmacy'; break;
		case 'insurance': return 'Payor'; break;
	}
}

function get_encounter_next_entity($entity_type)
{
	switch($entity_type)
	{
		case 'clinic' : return 'pharmacy';
		case 'pharmacy' : return 'insurance';
		case 'insurance' : return false;
	}
}


function get_entity_key(entity_type)
{
	switch(entity_type)
	{
		case 'clinic' : return 'clinic_id';
		case 'pharmacy' : return 'pharmacy+id';
		case 'insurance' : return 'insurance_id';
		case 'company' : return 'company_id';
	}
}

function get_short_service_type(service_type)
{
	switch(service_type)
	{
		case 'electronic_sample' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">ES</span>';
		case 'electronic_coupon' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">EC</span>';
		case 'physical_sample' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">PS</span>';
		case 'physical_coupon' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">PC</span>';
		case 'enroll_services' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">ES</span>';
		case 'decision_support' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">DS</span>';
		case 'financial_assistance' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">FA</span>';
		case 'call_reminder' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">CR</span>';
		case 'education_materials' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">EM</span>';
		case 'injection_training' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">IT</span>';
		case 'prior_authorization' : return '<span title="'+ lang['lbl_service_type_' + service_type] +'">PA</span>';
	}
}

function get_drug_brand_name(drug)
{
	return drug['trade_name'];
}

function get_drug_trade_name(drug)
{
	return drug['generic_name'];
}

function get_drug_generic_name(drug)
{
	return drug['generic_name'];
}

function get_inventory_item_no(drug , inventory_item)
{
	return drug['prefix']+ '-' +zero_pad(inventory_item['label_no'], 4);
}

function get_inventory_label_no(item_no)
{
	item_no = item_no.replace(/\D/g,'');
	return parseInt(item_no);
}

function get_user_photo_url(photo_id)
{
	return photo_id != "" ? get_render_url(photo_id) : g.base_url + 'assets/admin/images/default_photo.jpg';
}
