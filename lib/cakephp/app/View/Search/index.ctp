<style type="text/css">
#result, #loading {
  display: none;
}
</style>
<script>
$(function() {
	$("#button").one('click', function() {
		$("#loading").show();
		$("#result").load('search/request', function() {
			$("#loading").fadeOut(function() {
				$("#result").show();
			});
		});
	});
});
</script>
<div class="container-fluid">
	<h1>イベントマッププロジェクト</h1>
	<div class="row-fluid">
	<?php echo $this->Form->create(false,array('action'=>'request','type'=>'get'));?>
		<fieldset class="form-inline control-group">
			<input type="text" name="keyword" value="" >
			<label for="or" class="radio">
			<input type="radio" value="or" name="search_type" id="or" checked="checked">or</label>
			<label for="and" class="radio"><input type="radio" value="and" name="search_type" id="and">and</label>
		</fieldset>
		<fieldset class="form-inline control-group">
			<input type="date" value="">
			<input type="date" value="">
			<select name="pref">
					<option value="" selected>都道府県
					<option value="北海道">北海道
					<option value="青森県">青森県
					<option value="岩手県">岩手県
					<option value="宮城県">宮城県
					<option value="秋田県">秋田県
					<option value="山形県">山形県
					<option value="福島県">福島県
					<option value="茨城県">茨城県
					<option value="栃木県">栃木県
					<option value="群馬県">群馬県
					<option value="埼玉県">埼玉県
					<option value="千葉県">千葉県
					<option value="東京都">東京都
					<option value="神奈川県">神奈川県
					<option value="新潟県">新潟県
					<option value="富山県">富山県
					<option value="石川県">石川県
					<option value="福井県">福井県
					<option value="山梨県">山梨県
					<option value="長野県">長野県
					<option value="岐阜県">岐阜県
					<option value="静岡県">静岡県
					<option value="愛知県">愛知県
					<option value="三重県">三重県
					<option value="滋賀県">滋賀県
					<option value="京都府">京都府
					<option value="大阪府">大阪府
					<option value="兵庫県">兵庫県
					<option value="奈良県">奈良県
					<option value="和歌山県">和歌山県
					<option value="鳥取県">鳥取県
					<option value="島根県">島根県
					<option value="岡山県">岡山県
					<option value="広島県">広島県
					<option value="山口県">山口県
					<option value="徳島県">徳島県
					<option value="香川県">香川県
					<option value="愛媛県">愛媛県
					<option value="高知県">高知県
					<option value="福岡県">福岡県
					<option value="佐賀県">佐賀県
					<option value="長崎県">長崎県
					<option value="熊本県">熊本県
					<option value="大分県">大分県
					<option value="宮崎県">宮崎県
					<option value="鹿児島県">鹿児島県
					<option value="沖縄県">沖縄県
				</select>
		</fieldset>
		<fieldset class="form-inline control-group">
			<div class="btn-group" data-toggle="buttons-checkbox">
				<button class="btn">atend</button>
				<button class="btn">zusaar</button>
				<button class="btn">connpass</button>
			</div>
		</fieldset>
		<div class="control-group">
			<button type="button" class="btn btn-primary" data-loading-text="Loading..." id="button">検索</button>
		</div>
		<?php echo $this->Form->end();?>
		<div id="loading"><img src="img/loading.gif" /></div>
		<div id="result">
		</div>
	</div>
</div>
