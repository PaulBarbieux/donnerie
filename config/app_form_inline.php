<?php
// https://book.cakephp.org/3.0/en/views/helpers/form.html#customizing-the-templates-formhelper-uses

return [
	'inputSubmit' => '<button type="submit" class="btn btn-primary" {{attrs}}>Envoyer</button>',
	'label' => '<label class="{{collabel}} col-form-label" {{attrs}}>{{text}}</label>',
	'inputContainer' => '<DIV class="form-group row">{{content}}</DIV>',
	'input' => '<div class="{{colinput}}"><input type="{{type}}" name="{{name}}" class="form-control" {{attrs}}/></div>',
	'select' => '<div class="{{colinput}}"><select name="{{name}}" class="form-control" {{attrs}}>{{content}}</select></div>',
	'textarea' => '<div class="{{colinput}}"><textarea name="{{name}}" class="form-control" {{attrs}}>{{value}}</textarea></div>',
	'nestingLabel' => '{{hidden}}<label class="form-check-label" {{attrs}}>{{input}} {{text}}</label>',
	'radio' => '<input type="radio" name="{{name}}" value="{{value}}" class="form-check-input" {{attrs}}>',
	'file' => '<input type="file" name="{{name}}" class="custom-file-input" {{attrs}}>'
];
?>