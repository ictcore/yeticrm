{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="modal-header container-fluid openStreetMapModalHeader">
		<div class="col-xs-5">
			<h3 id="massEditHeader" class="modal-title">{\App\Language::translate('LBL_MAP', $MODULE_NAME)}</h3>
		</div>
		<div class="col-xs-6">
			<div class="col-xs-8 noSpaces">
				<input type="text" class="searchValue form-control" placeholder="{\App\Language::translate('LBL_SEARCH_VALUE_DESCRIPTION', $MODULE_NAME)}">
			</div>
			<div class="col-xs-4 noSpaces">
				<div class="input-group group-btn">
					<input type="text" class="form-control radius" placeholder="{\App\Language::translate('LBL_IN_RADIUS', $MODULE_NAME)}">
					<div class="input-group-btn">
						<button class="btn btn-primary searchBtn">{\App\Language::translate('LBL_SEARCH', $MODULE_NAME)}</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-1">
			<button type="button" class="btn btn-warning pull-right marginLeft10" data-dismiss="modal" aria-hidden="true">&times;</button>
		</div>
	</div>
	<div class="modal-body container-fluid openStreetMapModalBody">
		<div class="col-xs-9 paddingLRZero">
			<div id="mapid"></div>
		</div>
		<div class="col-xs-3">
			<div class="col-xs-12 paddingLRZero ">
				<div class="col-xs-7 form-group paddingLefttZero">
					<div class="input-group">
						<input type="text" class="form-control searchCompany">
						<span class="input-group-btn">
							<button class="btn btn-default addRecord" type="button">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>
				</div>
				<div class="col-xs-5 paddingLRZero">
					<select class="select2 searchModule col-xs-6">
						{foreach from=$ALLOWED_MODULES item=ALLOWED_MODULE_NAME}
							<option value="{$ALLOWED_MODULE_NAME}">{\App\Language::translate($ALLOWED_MODULE_NAME, $ALLOWED_MODULE_NAME)}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="input-group group-btn form-group">
				<select class="select2 fieldsToGroup">
					<optgroup label="{\App\Language::translate($SRC_MODULE, $SRC_MODULE)}">
					{foreach from=$FIELDS_TO_GROUP item=FIELD_MODEL}
						<option value="{$FIELD_MODEL->getFieldName()}">{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $SRC_MODULE)}</option>
					{/foreach}
					</optgroup>
				</select>
				<span class="input-group-addon">
					<input class="popoverTooltip groupNeighbours" type="checkbox" checked="checked" data-content="{\App\Language::translate('LBL_GROUP_NEIGHBOURS', $MODULE_NAME)}" class="groupNeighbours">
				</span>
				<div class="input-group-btn">
					<button class="btn btn-primary groupBy">{\App\Language::translate('LBL_GROUP_BY', $MODULE_NAME)}</button>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					{\App\Language::translate('LBL_CALCULATE_ROUTE_HEADER_BLOCK', $MODULE_NAME)}
				</div>
				<div class="panel-body track">
					<div class="input-group group-btn input-group-sm form-group startContainer">
						<input type="text" readonly="readonly" class="form-control start">
						<div class="input-group-btn">
							<button class="btn btn-success btn-sm setView">
								<span class="fa fa-truck"></span>
							</button>
						</div>
					</div>
					<div class="input-group group-btn input-group-sm form-group indirectContainer indirectTemplate hide">
						<input type="text" readonly="readonly" class="form-control indirect ">
						<div class="input-group-btn">
							<button class="btn btn-warning btn-sm setView">
								<span class="fa fa-flag"></span>
							</button>
							<button class="btn btn-success btn-sm moveUp">
								<span class="fa fa-arrow-up"></span>
							</button>
							<button class="btn btn-success  btn-sm moveDown">
								<span class="fa fa-arrow-down"></span>
							</button>
							<button class="btn btn-danger btn-sm removeIndirect">
								<span class="glyphicon glyphicon-remove"></span>
							</button>
						</div>
					</div>
					<div class="input-group group-btn input-group-sm form-group">
						<input type="text" readonly="readonly" class="form-control end">
						<div class="input-group-btn">
							<button class="btn btn-danger btn-sm setView">
								<span class="fa fa-flag-checkered"></span>
							</button>
						</div>
					</div>
					<div class="form-group pull-right">
						<button class="btn btn-primary hide calculateTrack">{\App\Language::translate('LBL_CALCULATE_TRACK', $MODULE_NAME)}</button>
					</div>
				</div>
			</div>
			<div class="panel panel-default cacheContainer">
				<div class="panel-heading">
					{\App\Language::translate('LBL_CLIPBOARD', $MODULE_NAME)}
				</div>
				<div class="panel-body cacheContent">
					{foreach from=$ALLOWED_MODULES item=ALLOWED_MODULE_NAME}
						<div class="cacheModuleContainer">
							<div class="col-xs-8">
								<label>
									<input type="checkbox" class="showRecordsFromCache" data-module="{$ALLOWED_MODULE_NAME}">
									&nbsp;{\App\Language::translate($ALLOWED_MODULE_NAME, $ALLOWED_MODULE_NAME)}&nbsp;
									<span class="badge countRecords{$ALLOWED_MODULE_NAME}">
										{if !empty($CACHE_GROUP_RECORDS[$ALLOWED_MODULE_NAME])}
											{$CACHE_GROUP_RECORDS[$ALLOWED_MODULE_NAME]}
										{/if}
									</span>
								</label>
							</div>
							<div class="col-xs-4">
								<button class="btn btn-xs btn-success addAllRecords pull-right" data-module="{$ALLOWED_MODULE_NAME}"><span class="glyphicon glyphicon-download-alt"></span></button>
								<button class="btn btn-xs btn-danger deleteClipBoard pull-right marginRight10 {if empty($CACHE_GROUP_RECORDS[$ALLOWED_MODULE_NAME])}hide{/if}" data-module="{$ALLOWED_MODULE_NAME}"><span class="fa fa-trash"></span></button>
							</div>
						</div>
					{/foreach}
					<div class="col-xs-12">
						<button class="btn btn-success btn-sm copyToClipboard pull-right"><span class="fa fa-clipboard"></span>&nbsp;{\App\Language::translate('LBL_COPY_TO_CLIPBOARD', $MODULE_NAME)}</button>
					</div>
				</div>
			</div>
			<div class="panel panel-default hide descriptionContainer">
				<div class="panel-body descriptionContent">
					<b>{\App\Language::translate('LBL_DISTANCE', $MODULE_NAME)}:&nbsp</b><span class="distance"></span><br />
					<b>{\App\Language::translate('LBL_TRAVEL_TIME', $MODULE_NAME)}:&nbsp</b><span class="travelTime"></span><br />
					<b>{\App\Language::translate('LBL_INSTRUCTION', $MODULE_NAME)}:&nbsp</b><span class="instruction"></span>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
	</div>
{/strip}
