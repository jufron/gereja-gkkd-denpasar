<?php

return [
    'settings' => [
        'default' => [
            'HTML.Doctype' => 'XHTML 1.0 Transitional',
            'HTML.SafeIframe' => true,
            'HTML.Allowed' => '
                p,br,strong,b,em,i,u,s,strike,
                h1,h2,h3,h4,h5,h6,
                ul,ol,li,
                blockquote,
                code,pre,
                a[href|rel|target|title],
                img[src|alt|title|width|height],
                span[class],
                div[class]
            ',
        ],
    ],
];
