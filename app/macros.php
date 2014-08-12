<?php

Form::macro('textField', function ($name, $label, $value = null)
{
    $html = '<div class="form-group"><label class="col-sm-3 text-right" for="' . $name . '">' . $label . '</label><div class="col-sm-9">';
    $html .= Form::text($name, $value, ['class' => 'form-control']);
    $html .= '</div></div>';

    return $html;
});

Form::macro('emailField', function ($name, $label, $value = null)
{
    $html = '<div class="form-group"><label class="col-sm-3 text-right" for="' . $name . '">' . $label . '</label><div class="col-sm-9">';
    $html .= Form::email($name, $value, ['class' => 'form-control']);
    $html .= '</div></div>';

    return $html;
});

Form::macro('passwordField', function ($name, $label)
{
    $html = '<div class="form-group"><label class="col-sm-3 text-right" for="' . $name . '">' . $label . '</label><div class="col-sm-9">';
    $html .= Form::password($name);
    $html .= '</div></div>';

    return $html;
});

Form::macro('textAreaField', function ($name, $label, $value = null)
{
    $html = '<div class="form-group"><label class="col-sm-3 text-right" for="' . $name . '">' . $label . '</label><div class="col-sm-9">';
    $html .= Form::textarea($name, $value, ['class' => 'form-control', 'cols' => '50', 'rows' => '4']);
    $html .= '</div></div>';

    return $html;
});

Form::macro('fileSelector', function ($name, $label, $currentImage = null)
{
    $html = '<div class="form-group"><label class="col-sm-3 text-right">' . $label . '</label><div class="col-sm-9"><label for="' . $name . '"><div id="' . $name . '-preview' . '" class="file-select-box">';
    $html .= '<p><span class="glyphicon glyphicon-picture">&nbsp;</span>Click to select file</p>';
    $html .= Form::file($name, ['id' => $name]);
    if ($currentImage && file_exists(public_path($currentImage)))
    {
        $html .= '<image alt="preview image" src="' . asset($currentImage) . '">';
    }
    $html .= '</div></label></div>';

    return $html;
});

Form::macro('passwordWithConfirmation', function ($name, $label)
{
    $html = '<div class="form-group"><label class="col-sm-3 text-right" for="' . $name . '">' . $label . '</label><div class="col-sm-9">';
    $html .= Form::password($name, ['id' => $name]);
    $html .= '</div></div>';
    $html .= '<div class="form-group"><label class="col-sm-3 text-right" for="' . $name . '_confirmation">Confirm ' . $label . '</label><div class="col-sm-9">';
    $html .= Form::password($name . '_confirmation', ['id' => $name . '_confirmation']);
    $html .= '</div></div>';

    return $html;
});

Form::macro('submitField', function ($name, $value)
{
    $html = '<div class="form-group"><div class="col-sm-offset-4 col-sm-4">';
    $html .= '<button type="submit" name="' . $name . '" class="btn btn-danger form-control blockbutton">' . $value . '</button></div></div>';


    return $html;
});