<?php

namespace Jiannius\Atom\Components;

use Illuminate\View\Component;

class Icon extends Component
{
    public $icon;
    public $size;
    public $style;
    public $family;

    public $fa = [
        'xmark' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/></svg>',
        'trash-arrow-up' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM207 199L127 279C117.7 288.4 117.7 303.6 127 312.1C136.4 322.3 151.6 322.3 160.1 312.1L199.1 273.9V408C199.1 421.3 210.7 432 223.1 432C237.3 432 248 421.3 248 408V273.9L287 312.1C296.4 322.3 311.6 322.3 320.1 312.1C330.3 303.6 330.3 288.4 320.1 279L240.1 199C236.5 194.5 230.4 191.1 223.1 191.1C217.6 191.1 211.5 194.5 207 199V199z"/></svg>',
        'bullhorn' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M480 179.6C498.6 188.4 512 212.1 512 240C512 267.9 498.6 291.6 480 300.4V448C480 460.9 472.2 472.6 460.2 477.6C448.3 482.5 434.5 479.8 425.4 470.6L381.7 426.1C333.7 378.1 268.6 352 200.7 352H192V480C192 497.7 177.7 512 160 512H96C78.33 512 64 497.7 64 480V352C28.65 352 0 323.3 0 288V192C0 156.7 28.65 128 64 128H200.7C268.6 128 333.7 101 381.7 53.02L425.4 9.373C434.5 .2215 448.3-2.516 460.2 2.437C472.2 7.39 480 19.06 480 32V179.6zM200.7 192H192V288H200.7C280.5 288 357.2 317.8 416 371.3V108.7C357.2 162.2 280.5 192 200.7 192V192z"/></svg>',
        'exclamation' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M64 352c17.69 0 32-14.32 32-31.1V64.01c0-17.67-14.31-32.01-32-32.01S32 46.34 32 64.01v255.1C32 337.7 46.31 352 64 352zM64 400c-22.09 0-40 17.91-40 40s17.91 39.1 40 39.1s40-17.9 40-39.1S86.09 400 64 400z"/></svg>',
        'money-bill-transfer' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M535 7.03C544.4-2.343 559.6-2.343 568.1 7.029L632.1 71.02C637.5 75.52 640 81.63 640 87.99C640 94.36 637.5 100.5 632.1 104.1L568.1 168.1C559.6 178.3 544.4 178.3 535 168.1C525.7 159.6 525.7 144.4 535 135L558.1 111.1L384 111.1C370.7 111.1 360 101.2 360 87.99C360 74.74 370.7 63.99 384 63.99L558.1 63.1L535 40.97C525.7 31.6 525.7 16.4 535 7.03V7.03zM104.1 376.1L81.94 400L255.1 399.1C269.3 399.1 279.1 410.7 279.1 423.1C279.1 437.2 269.3 447.1 255.1 447.1L81.95 448L104.1 471C114.3 480.4 114.3 495.6 104.1 504.1C95.6 514.3 80.4 514.3 71.03 504.1L7.029 440.1C2.528 436.5-.0003 430.4 0 423.1C0 417.6 2.529 411.5 7.03 407L71.03 343C80.4 333.7 95.6 333.7 104.1 343C114.3 352.4 114.3 367.6 104.1 376.1H104.1zM95.1 64H337.9C334.1 71.18 332 79.34 332 87.1C332 116.7 355.3 139.1 384 139.1L481.1 139.1C484.4 157.5 494.9 172.5 509.4 181.9C511.1 184.3 513.1 186.6 515.2 188.8C535.5 209.1 568.5 209.1 588.8 188.8L608 169.5V384C608 419.3 579.3 448 544 448H302.1C305.9 440.8 307.1 432.7 307.1 423.1C307.1 395.3 284.7 371.1 255.1 371.1L158.9 372C155.5 354.5 145.1 339.5 130.6 330.1C128.9 327.7 126.9 325.4 124.8 323.2C104.5 302.9 71.54 302.9 51.23 323.2L31.1 342.5V128C31.1 92.65 60.65 64 95.1 64V64zM95.1 192C131.3 192 159.1 163.3 159.1 128H95.1V192zM544 384V320C508.7 320 480 348.7 480 384H544zM319.1 352C373 352 416 309 416 256C416 202.1 373 160 319.1 160C266.1 160 223.1 202.1 223.1 256C223.1 309 266.1 352 319.1 352z"/></svg>',
        'chart-line' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M64 400C64 408.8 71.16 416 80 416H480C497.7 416 512 430.3 512 448C512 465.7 497.7 480 480 480H80C35.82 480 0 444.2 0 400V64C0 46.33 14.33 32 32 32C49.67 32 64 46.33 64 64V400zM342.6 278.6C330.1 291.1 309.9 291.1 297.4 278.6L240 221.3L150.6 310.6C138.1 323.1 117.9 323.1 105.4 310.6C92.88 298.1 92.88 277.9 105.4 265.4L217.4 153.4C229.9 140.9 250.1 140.9 262.6 153.4L320 210.7L425.4 105.4C437.9 92.88 458.1 92.88 470.6 105.4C483.1 117.9 483.1 138.1 470.6 150.6L342.6 278.6z"/></svg>',
        'folder-open' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M572.6 270.3l-96 192C471.2 473.2 460.1 480 447.1 480H64c-35.35 0-64-28.66-64-64V96c0-35.34 28.65-64 64-64h117.5c16.97 0 33.25 6.742 45.26 18.75L275.9 96H416c35.35 0 64 28.66 64 64v32h-48V160c0-8.824-7.178-16-16-16H256L192.8 84.69C189.8 81.66 185.8 80 181.5 80H64C55.18 80 48 87.18 48 96v288l71.16-142.3C124.6 230.8 135.7 224 147.8 224h396.2C567.7 224 583.2 249 572.6 270.3z"/></svg>',
        'location-dot' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"/></svg>',
        'envelope' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 352c-16.53 0-33.06-5.422-47.16-16.41L0 173.2V400C0 426.5 21.49 448 48 448h416c26.51 0 48-21.49 48-48V173.2l-208.8 162.5C289.1 346.6 272.5 352 256 352zM16.29 145.3l212.2 165.1c16.19 12.6 38.87 12.6 55.06 0l212.2-165.1C505.1 137.3 512 125 512 112C512 85.49 490.5 64 464 64h-416C21.49 64 0 85.49 0 112C0 125 6.01 137.3 16.29 145.3z"/></svg>',
        'phone' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M511.2 387l-23.25 100.8c-3.266 14.25-15.79 24.22-30.46 24.22C205.2 512 0 306.8 0 54.5c0-14.66 9.969-27.2 24.22-30.45l100.8-23.25C139.7-2.602 154.7 5.018 160.8 18.92l46.52 108.5c5.438 12.78 1.77 27.67-8.98 36.45L144.5 207.1c33.98 69.22 90.26 125.5 159.5 159.5l44.08-53.8c8.688-10.78 23.69-14.51 36.47-8.975l108.5 46.51C506.1 357.2 514.6 372.4 511.2 387z"/></svg>',
        'house' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M575.8 255.5C575.8 273.5 560.8 287.6 543.8 287.6H511.8L512.5 447.7C512.5 450.5 512.3 453.1 512 455.8V472C512 494.1 494.1 512 472 512H456C454.9 512 453.8 511.1 452.7 511.9C451.3 511.1 449.9 512 448.5 512H392C369.9 512 352 494.1 352 472V384C352 366.3 337.7 352 320 352H256C238.3 352 224 366.3 224 384V472C224 494.1 206.1 512 184 512H128.1C126.6 512 125.1 511.9 123.6 511.8C122.4 511.9 121.2 512 120 512H104C81.91 512 64 494.1 64 472V360C64 359.1 64.03 358.1 64.09 357.2V287.6H32.05C14.02 287.6 0 273.5 0 255.5C0 246.5 3.004 238.5 10.01 231.5L266.4 8.016C273.4 1.002 281.4 0 288.4 0C295.4 0 303.4 2.004 309.5 7.014L564.8 231.5C572.8 238.5 576.9 246.5 575.8 255.5L575.8 255.5z"/></svg>',
        'check' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z"/></svg>',
        'plus' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z"/></svg>',
        'language' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M448 164C459 164 468 172.1 468 184V188H528C539 188 548 196.1 548 208C548 219 539 228 528 228H526L524.4 232.5C515.5 256.1 501.9 279.1 484.7 297.9C485.6 298.4 486.5 298.1 487.4 299.5L506.3 310.8C515.8 316.5 518.8 328.8 513.1 338.3C507.5 347.8 495.2 350.8 485.7 345.1L466.8 333.8C462.4 331.1 457.1 328.3 453.7 325.3C443.2 332.8 431.8 339.3 419.8 344.7L416.1 346.3C406 350.8 394.2 346.2 389.7 336.1C385.2 326 389.8 314.2 399.9 309.7L403.5 308.1C409.9 305.2 416.1 301.1 422 298.3L409.9 286.1C402 278.3 402 265.7 409.9 257.9C417.7 250 430.3 250 438.1 257.9L452.7 272.4L453.3 272.1C465.7 259.9 475.8 244.7 483.1 227.1H376C364.1 227.1 356 219 356 207.1C356 196.1 364.1 187.1 376 187.1H428V183.1C428 172.1 436.1 163.1 448 163.1L448 164zM160 233.2L179 276H140.1L160 233.2zM0 128C0 92.65 28.65 64 64 64H576C611.3 64 640 92.65 640 128V384C640 419.3 611.3 448 576 448H64C28.65 448 0 419.3 0 384V128zM320 384H576V128H320V384zM178.3 175.9C175.1 168.7 167.9 164 160 164C152.1 164 144.9 168.7 141.7 175.9L77.72 319.9C73.24 329.1 77.78 341.8 87.88 346.3C97.97 350.8 109.8 346.2 114.3 336.1L123.2 315.1H196.8L205.7 336.1C210.2 346.2 222 350.8 232.1 346.3C242.2 341.8 246.8 329.1 242.3 319.9L178.3 175.9z"/></svg>',
        'file-circle-plus' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-full h-full" fill="currentcolor"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 64C0 28.65 28.65 0 64 0H224V128C224 145.7 238.3 160 256 160H384V198.6C310.1 219.5 256 287.4 256 368C256 427.1 285.1 479.3 329.7 511.3C326.6 511.7 323.3 512 320 512H64C28.65 512 0 483.3 0 448V64zM256 128V0L384 128H256zM288 368C288 288.5 352.5 224 432 224C511.5 224 576 288.5 576 368C576 447.5 511.5 512 432 512C352.5 512 288 447.5 288 368zM448 303.1C448 295.2 440.8 287.1 432 287.1C423.2 287.1 416 295.2 416 303.1V351.1H368C359.2 351.1 352 359.2 352 367.1C352 376.8 359.2 383.1 368 383.1H416V431.1C416 440.8 423.2 447.1 432 447.1C440.8 447.1 448 440.8 448 431.1V383.1H496C504.8 383.1 512 376.8 512 367.1C512 359.2 504.8 351.1 496 351.1H448V303.1z"/></svg>',
    ];

    /**
     * Create the component instance.
     *
     * @return void
     */
    public function __construct(
        $name = null,
        $type = 'regular',
        $size = 'sm',
    ) {
        $this->icon = $this->getIcon($name, $type);
        $this->size = $this->getSize($size);
        $this->style = $this->getStyle();
    }

    /**
     * Get icon
     */
    public function getIcon($name, $type)
    {
        if ($icon = $this->fa[$name] ?? null) {
            $this->family = 'fa';
            return $icon;
        }
        else {
            $prefix = $type === 'regular' ? 'bx-' : 'bx'.substr($type, 0, 1).'-';

            $this->family = 'box';
            return $prefix.$name;
        }
    }

    /**
     * Get size
     */
    public function getSize($size)
    {
        if ($this->family === 'fa') {
            $sizes = [
                'xs' => '16',
                'sm' => '24',
                'md' => '32',
                'lg' => '40',
                'xl' => '48',
                '2xl' => '56',
            ];
    
            return in_array($size, array_keys($sizes))
                ? $sizes[$size]
                : ($size ? str_replace('px', '', $size) : $sizes['sm']);
        }
        else if ($this->family === 'box') {
            $sizes = [
                'xs' => 'text-lg',
                'sm' => 'text-2xl',
                'md' => 'text-3xl',
                'lg' => 'text-4xl',
                'xl' => 'text-5xl',
                '2xl' => 'text-7xl',
            ];
    
            return in_array($size, array_keys($sizes))
                ? $sizes[$size]
                : ($size ?? $sizes['sm']);
        }
    }

    /**
     * Get style
     */
    public function getStyle()
    {
        return str($this->size)->endsWith('px') 
            ? "style=\"font-size: {$this->size};\"" 
            : null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('atom::components.icon');
    }
}