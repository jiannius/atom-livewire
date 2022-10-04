<?php

namespace Jiannius\Atom\Components;

use Illuminate\View\Component;

class Logo extends Component
{
    public $src;
    public $name;
    public $size;
    public $small;

    public $sources = [
        'fpx' => 'https://www.bankislam.com/wp-content/uploads/FPX-Logo.jpg',
        'visa' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 42 24" class="w-full h-full object-contain"><title>Visa</title><path fill="var(--paymentLogoColor, #1434cb)" d="M20.8 5.31L17.97 18.9h-3.43l2.83-13.58h3.43zm14.23 8.78l1.82-5.12 1.01 5.12h-2.83zm3.84 4.8H42L39.27 5.31h-2.92c-.61 0-1.22.42-1.42 1.05l-5.05 12.53h3.54l.7-1.98h4.35l.4 1.98zm-8.88-4.49c0-3.55-4.75-3.76-4.75-5.33.1-.73.7-1.15 1.41-1.15 1.11-.1 2.33.1 3.34.63l.6-2.92A8.36 8.36 0 0 0 27.46 5c-3.33 0-5.75 1.88-5.75 4.5 0 1.98 1.71 3.02 2.92 3.65 1.32.62 1.82 1.04 1.72 1.67 0 .94-1 1.36-2.02 1.36a8.37 8.37 0 0 1-3.53-.84l-.6 2.92c1.2.53 2.52.74 3.73.74 3.73.1 6.06-1.78 6.06-4.6zM15.95 5.31L10.5 18.9H6.87L4.14 8.03c0-.52-.4-.94-.8-1.15A11.5 11.5 0 0 0 0 5.73l.1-.42h5.76c.8 0 1.4.63 1.51 1.36l1.41 7.83 3.64-9.19h3.53z"></path></svg>',
        'master' => 'https://www.mastercard.com/content/dam/public/mastercardcom/mea/za/logos/mc-logo-52.svg',
        'tng' => 'https://www.touchngo.com.my/assets/logos/tngd-logo.svg',
        'ozopay' => 'https://www.ozopay.com/wp-content/uploads/2021/12/logo.svg',
        'ipay' => 'https://www.ipay88.com/wp-content/uploads/2021/02/ipay88-logo-white.png',
        'google-pay' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 435.97 173.13" class="w-full h-full object-contain""><path d="M206.2,84.58v50.75H190.1V10h42.7a38.61,38.61,0,0,1,27.65,10.85A34.88,34.88,0,0,1,272,47.3a34.72,34.72,0,0,1-11.55,26.6q-11.2,10.68-27.65,10.67H206.2Zm0-59.15V69.18h27a21.28,21.28,0,0,0,15.93-6.48,21.36,21.36,0,0,0,0-30.63,21,21,0,0,0-15.93-6.65h-27Z" fill="#5f6368"></path><path d="M309.1,46.78q17.85,0,28.18,9.54T347.6,82.48v52.85H332.2v-11.9h-.7q-10,14.7-26.6,14.7-14.17,0-23.71-8.4a26.82,26.82,0,0,1-9.54-21q0-13.31,10.06-21.17t26.86-7.88q14.34,0,23.62,5.25V81.25A18.33,18.33,0,0,0,325.54,67,22.8,22.8,0,0,0,310,61.13q-13.49,0-21.35,11.38l-14.18-8.93Q286.17,46.78,309.1,46.78Zm-20.83,62.3a12.86,12.86,0,0,0,5.34,10.5,19.64,19.64,0,0,0,12.51,4.2,25.67,25.67,0,0,0,18.11-7.52q8-7.53,8-17.67-7.53-6-21-6-9.81,0-16.36,4.73C290.46,100.52,288.27,104.41,288.27,109.08Z" fill="#5f6368"></path><path d="M436,49.58,382.24,173.13H365.62l19.95-43.23L350.22,49.58h17.5l25.55,61.6h.35l24.85-61.6Z" fill="#5f6368"></path><path d="M141.14,73.64A85.79,85.79,0,0,0,139.9,59H72V86.73h38.89a33.33,33.33,0,0,1-14.38,21.88v18h23.21C133.31,114.08,141.14,95.55,141.14,73.64Z" fill="#4285f4"></path><path d="M72,144c19.43,0,35.79-6.38,47.72-17.38l-23.21-18C90.05,113,81.73,115.5,72,115.5c-18.78,0-34.72-12.66-40.42-29.72H7.67v18.55A72,72,0,0,0,72,144Z" fill="#34a853"></path><path d="M31.58,85.78a43.14,43.14,0,0,1,0-27.56V39.67H7.67a72,72,0,0,0,0,64.66Z" fill="#fbbc04"></path><path d="M72,28.5A39.09,39.09,0,0,1,99.62,39.3h0l20.55-20.55A69.18,69.18,0,0,0,72,0,72,72,0,0,0,7.67,39.67L31.58,58.22C37.28,41.16,53.22,28.5,72,28.5Z" fill="#ea4335"></path></svg>',
        'apple-pay' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 210.2" class="w-full h-full object-contain"><path id="XMLID_34_" d="M93.6,27.1C87.6,34.2,78,39.8,68.4,39c-1.2-9.6,3.5-19.8,9-26.1c6-7.3,16.5-12.5,25-12.9 C103.4,10,99.5,19.8,93.6,27.1 M102.3,40.9c-13.9-0.8-25.8,7.9-32.4,7.9c-6.7,0-16.8-7.5-27.8-7.3c-14.3,0.2-27.6,8.3-34.9,21.2 c-15,25.8-3.9,64,10.6,85c7.1,10.4,15.6,21.8,26.8,21.4c10.6-0.4,14.8-6.9,27.6-6.9c12.9,0,16.6,6.9,27.8,6.7 c11.6-0.2,18.9-10.4,26-20.8c8.1-11.8,11.4-23.3,11.6-23.9c-0.2-0.2-22.4-8.7-22.6-34.3c-0.2-21.4,17.5-31.6,18.3-32.2 C123.3,42.9,107.7,41.3,102.3,40.9 M182.6,11.9v155.9h24.2v-53.3h33.5c30.6,0,52.1-21,52.1-51.4c0-30.4-21.1-51.2-51.3-51.2H182.6z  M206.8,32.3h27.9c21,0,33,11.2,33,30.9c0,19.7-12,31-33.1,31h-27.8V32.3z M336.6,169c15.2,0,29.3-7.7,35.7-19.9h0.5v18.7h22.4V90.2 c0-22.5-18-37-45.7-37c-25.7,0-44.7,14.7-45.4,34.9h21.8c1.8-9.6,10.7-15.9,22.9-15.9c14.8,0,23.1,6.9,23.1,19.6v8.6l-30.2,1.8 c-28.1,1.7-43.3,13.2-43.3,33.2C298.4,155.6,314.1,169,336.6,169z M343.1,150.5c-12.9,0-21.1-6.2-21.1-15.7c0-9.8,7.9-15.5,23-16.4 l26.9-1.7v8.8C371.9,140.1,359.5,150.5,343.1,150.5z M425.1,210.2c23.6,0,34.7-9,44.4-36.3L512,54.7h-24.6l-28.5,92.1h-0.5 l-28.5-92.1h-25.3l41,113.5l-2.2,6.9c-3.7,11.7-9.7,16.2-20.4,16.2c-1.9,0-5.6-0.2-7.1-0.4v18.7C417.3,210,423.3,210.2,425.1,210.2z "></path><g></g><g></g><g></g><g></g><g></g><g></g></svg>',
        'atom' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 350" class="w-full h-full object-contain"> <g id="Layer_1" display="none" opacity="0.5"> <g display="inline"> <g> <path d="M38.508,329.32c-10.176,0-17.438-3.488-21.797-10.465c-4.36-6.975-4.216-15.398,0.436-25.285l115.09-255.028 c3.775-8.426,8.353-14.455,13.733-18.092c5.374-3.631,11.553-5.45,18.528-5.45c6.681,0,12.709,1.819,18.091,5.45 c5.375,3.638,9.952,9.666,13.733,18.092L311.849,293.57c4.645,10.178,4.938,18.678,0.872,25.504 c-4.073,6.826-11.049,10.246-20.925,10.246c-8.14,0-14.461-1.963-18.965-5.887c-4.508-3.922-8.501-9.951-11.989-18.092 l-21.797-50.57H89.078l-21.361,50.57c-3.781,8.436-7.705,14.535-11.771,18.311C51.873,327.426,46.062,329.32,38.508,329.32z M163.626,79.084L108.26,210.307h111.604L164.498,79.084H163.626z"/> <path d="M478.375,330.191c-56.385,0-84.573-27.902-84.573-83.703v-92.857h-22.669c-14.537,0-21.798-6.825-21.798-20.489 c0-13.658,7.261-20.489,21.798-20.489h22.669V72.981c0-18.31,9.156-27.465,27.465-27.465c18.018,0,27.03,9.155,27.03,27.465 v39.671h46.209c14.53,0,21.797,6.832,21.797,20.489c0,13.665-7.267,20.489-21.797,20.489h-46.209v89.806 c0,13.951,3.052,24.414,9.152,31.389c6.106,6.973,15.983,10.463,29.644,10.463c4.938,0,9.298-0.436,13.079-1.311 c3.777-0.869,7.119-1.447,10.031-1.74c3.487-0.287,6.386,0.803,8.719,3.27c2.32,2.473,3.487,7.484,3.487,15.039 c0,5.816-0.95,10.973-2.836,15.479c-1.895,4.508-5.304,7.627-10.243,9.369c-3.781,1.158-8.719,2.248-14.824,3.27 C488.404,329.682,483.024,330.191,478.375,330.191z"/> <path d="M890.342,329.32c-18.023,0-27.027-9.299-27.027-27.902V136.631c0-18.311,8.861-27.466,26.592-27.466 c17.725,0,26.592,9.155,26.592,27.466v8.719c6.392-11.622,15.259-20.708,26.594-27.248s24.414-9.809,39.234-9.809 c31.969,0,52.895,13.95,62.777,41.851c6.682-13.079,16.273-23.323,28.773-30.735c12.492-7.411,26.736-11.116,42.722-11.116 c47.954,0,71.932,29.208,71.932,87.626v105.498c0,18.604-9.152,27.902-27.464,27.902c-18.023,0-27.029-9.299-27.029-27.902V198.1 c0-16.275-2.691-28.188-8.063-35.749c-5.381-7.555-14.463-11.335-27.247-11.335c-14.244,0-25.436,5.015-33.569,15.041 c-8.14,10.026-12.205,23.908-12.205,41.633v93.729c0,18.604-9.013,27.902-27.029,27.902c-18.312,0-27.465-9.299-27.465-27.902 V198.1c0-16.275-2.689-28.188-8.065-35.749c-5.381-7.555-14.32-11.335-26.811-11.335c-14.244,0-25.436,5.015-33.569,15.041 c-8.139,10.026-12.204,23.908-12.204,41.633v93.729C917.809,320.021,908.652,329.32,890.342,329.32z"/> </g> <g> <path fill="#674272" d="M701.244,92.154c-54.868,0-99.348,44.48-99.348,99.35c0,54.869,44.479,99.35,99.348,99.35 c54.869,0,99.349-44.48,99.349-99.35C800.593,136.634,756.113,92.154,701.244,92.154z M701.244,244.996 c-29.543,0-53.49-23.949-53.49-53.492c0-29.543,23.947-53.492,53.49-53.492c29.545,0,53.492,23.948,53.492,53.492 C754.736,221.047,730.789,244.996,701.244,244.996z"/> <circle fill="#674272" cx="797.677" cy="73.219" r="32.423"/> <circle fill="#674272" cx="593.871" cy="298.822" r="32.424"/> </g> </g> </g> <g id="Layer_2"> <g> <path d="M118.185,314.447c-15.136,0-28.625-2.931-40.469-8.779C65.865,299.82,56.584,291.897,49.88,281.9 c-6.711-9.99-10.064-21.265-10.064-33.831c0-15.417,3.995-27.622,11.991-36.615c7.989-8.993,20.984-15.483,38.97-19.485 c17.986-3.995,42.109-5.995,72.374-5.995h14.988v-8.993c0-14.272-3.145-24.551-9.421-30.834 c-6.283-6.276-16.849-9.421-31.69-9.421c-8.284,0-17.204,1.003-26.766,2.998c-9.569,2.001-19.632,5.427-30.191,10.278 c-6.852,3.145-12.566,3.5-17.13,1.071c-4.57-2.422-7.642-6.276-9.208-11.563c-1.572-5.28-1.285-10.633,0.856-16.06 c2.142-5.42,6.491-9.421,13.062-11.991c13.128-5.42,25.762-9.274,37.9-11.563c12.132-2.282,23.192-3.426,33.189-3.426 c30.546,0,53.243,7.066,68.091,21.198c14.841,14.132,22.269,36.046,22.269,65.736v102.779c0,18.273-8.284,27.407-24.838,27.407 c-16.849,0-25.267-9.134-25.267-27.407v-9.422c-4.858,11.71-12.566,20.917-23.125,27.622 C145.305,311.089,132.746,314.447,118.185,314.447z M129.32,277.618c13.985,0,25.621-4.852,34.902-14.561 c9.274-9.702,13.918-21.98,13.918-36.829v-9.421h-14.56c-26.839,0-45.468,2.074-55.886,6.209 c-10.425,4.143-15.631,11.637-15.631,22.483c0,9.421,3.279,17.13,9.85,23.125C108.476,274.62,117.61,277.618,129.32,277.618z"/> <path d="M426.521,314.447c-55.391,0-83.08-27.407-83.08-82.224v-91.216h-22.269c-14.279,0-21.412-6.705-21.412-20.127 c0-13.416,7.133-20.127,21.412-20.127h22.269V61.782c0-17.986,8.993-26.979,26.979-26.979c17.699,0,26.551,8.993,26.551,26.979 v38.971h45.395c14.271,0,21.412,6.711,21.412,20.127c0,13.423-7.141,20.127-21.412,20.127h-45.395v88.219 c0,13.704,2.998,23.981,8.993,30.834c5.996,6.852,15.698,10.277,29.12,10.277c4.852,0,9.135-0.428,12.848-1.284 c3.707-0.856,6.992-1.426,9.85-1.713c3.426-0.281,6.277,0.789,8.566,3.211c2.281,2.43,3.426,7.354,3.426,14.775 c0,5.714-0.932,10.779-2.785,15.202c-1.859,4.43-5.211,7.494-10.063,9.207c-3.715,1.138-8.566,2.209-14.561,3.212 C436.371,313.945,431.085,314.447,426.521,314.447z"/> <path d="M861.188,313.591c-17.706,0-26.552-9.134-26.552-27.407V124.306c0-17.986,8.706-26.979,26.123-26.979 c17.411,0,26.123,8.993,26.123,26.979v8.565c6.276-11.416,14.989-20.342,26.123-26.765c11.135-6.424,23.982-9.636,38.542-9.636 c31.403,0,51.959,13.704,61.668,41.112c6.564-12.848,15.985-22.911,28.265-30.191c12.271-7.28,26.264-10.92,41.968-10.92 c47.107,0,70.661,28.692,70.661,86.078v103.636c0,18.273-8.993,27.407-26.979,27.407c-17.706,0-26.552-9.134-26.552-27.407 V184.688c0-15.985-2.643-27.688-7.923-35.116c-5.286-7.42-14.205-11.134-26.765-11.134c-13.992,0-24.986,4.925-32.976,14.774 c-7.996,9.85-11.99,23.487-11.99,40.898v92.073c0,18.273-8.854,27.407-26.552,27.407c-17.986,0-26.979-9.134-26.979-27.407 V184.688c0-15.985-2.644-27.688-7.923-35.116c-5.286-7.42-14.065-11.134-26.337-11.134c-13.992,0-24.985,4.925-32.975,14.774 c-7.997,9.85-11.991,23.487-11.991,40.898v92.073C888.167,304.457,879.174,313.591,861.188,313.591z"/> <circle fill="#9A61A8" cx="647.765" cy="196.234" r="111.765"/> <circle fill="#9A61A8" cx="759.53" cy="69.031" r="37.843"/> </g> </g> </svg>',
        'atom-sm' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300" class="w-full h-full object-contain"> <g id="Layer_2"> <path d="M-371.631-94.591c-15.136,0-28.625-2.931-40.469-8.779c-11.851-5.848-21.131-13.771-27.836-23.768 c-6.711-9.99-10.064-21.265-10.064-33.831c0-15.417,3.995-27.622,11.991-36.615c7.989-8.993,20.984-15.483,38.97-19.485 c17.986-3.995,42.109-5.995,72.374-5.995h14.988v-8.993c0-14.272-3.145-24.551-9.421-30.834c-6.283-6.276-16.849-9.421-31.69-9.421 c-8.284,0-17.204,1.003-26.766,2.998c-9.569,2.001-19.632,5.427-30.191,10.278c-6.852,3.145-12.566,3.5-17.13,1.071 c-4.57-2.422-7.642-6.276-9.208-11.563c-1.572-5.28-1.285-10.633,0.856-16.06c2.142-5.42,6.491-9.421,13.062-11.991 c13.128-5.42,25.762-9.274,37.9-11.563c12.132-2.282,23.192-3.426,33.189-3.426c30.546,0,53.243,7.066,68.091,21.198 c14.841,14.132,22.269,36.046,22.269,65.736v102.779c0,18.273-8.284,27.407-24.838,27.407c-16.849,0-25.267-9.134-25.267-27.407 v-9.422c-4.858,11.71-12.566,20.917-23.125,27.622C-344.511-97.95-357.071-94.591-371.631-94.591z M-360.497-131.42 c13.985,0,25.621-4.852,34.902-14.561c9.274-9.702,13.918-21.98,13.918-36.829v-9.421h-14.56c-26.839,0-45.468,2.074-55.886,6.209 c-10.425,4.143-15.631,11.637-15.631,22.483c0,9.421,3.279,17.13,9.85,23.125C-381.34-134.418-372.207-131.42-360.497-131.42z"/> <path d="M-63.295-94.591c-55.391,0-83.08-27.407-83.08-82.224v-91.216h-22.269c-14.279,0-21.412-6.705-21.412-20.127 c0-13.416,7.133-20.127,21.412-20.127h22.269v-38.971c0-17.986,8.993-26.979,26.979-26.979c17.699,0,26.551,8.993,26.551,26.979 v38.971h45.395c14.271,0,21.412,6.711,21.412,20.127c0,13.423-7.141,20.127-21.412,20.127h-45.395v88.219 c0,13.704,2.998,23.981,8.993,30.834c5.996,6.852,15.698,10.277,29.12,10.277c4.852,0,9.135-0.428,12.848-1.284 c3.707-0.856,6.992-1.426,9.85-1.713c3.426-0.281,6.277,0.789,8.566,3.211c2.281,2.43,3.426,7.354,3.426,14.775 c0,5.714-0.932,10.779-2.785,15.202c-1.859,4.43-5.211,7.494-10.063,9.207c-3.715,1.138-8.566,2.209-14.561,3.212 C-53.445-95.093-58.731-94.591-63.295-94.591z"/> <path d="M371.371-95.448c-17.706,0-26.552-9.134-26.552-27.407v-161.878c0-17.986,8.706-26.979,26.123-26.979 c17.411,0,26.123,8.993,26.123,26.979v8.565c6.276-11.416,14.989-20.342,26.123-26.765c11.135-6.424,23.982-9.636,38.542-9.636 c31.403,0,51.959,13.704,61.668,41.112c6.564-12.848,15.985-22.911,28.265-30.191c12.271-7.28,26.264-10.92,41.968-10.92 c47.107,0,70.661,28.692,70.661,86.078v103.636c0,18.273-8.993,27.407-26.979,27.407c-17.706,0-26.552-9.134-26.552-27.407V-224.35 c0-15.985-2.643-27.688-7.923-35.116c-5.286-7.42-14.205-11.134-26.765-11.134c-13.992,0-24.986,4.925-32.976,14.774 c-7.996,9.85-11.99,23.487-11.99,40.898v92.073c0,18.273-8.854,27.407-26.552,27.407c-17.986,0-26.979-9.134-26.979-27.407V-224.35 c0-15.985-2.644-27.688-7.923-35.116c-5.286-7.42-14.065-11.134-26.337-11.134c-13.992,0-24.985,4.925-32.975,14.774 c-7.997,9.85-11.991,23.487-11.991,40.898v92.073C398.351-104.582,389.357-95.448,371.371-95.448z"/> <g> <circle fill="#7F62AA" cx="157.949" cy="-212.804" r="111.765"/> <circle fill="#7F62AA" cx="269.714" cy="-340.007" r="37.843"/> </g> <g> <circle fill="#7F62AA" cx="130.323" cy="177.731" r="118.323"/> <circle fill="#7F62AA" cx="248.646" cy="43.064" r="40.063"/> </g> </g> </svg>',
        'stripe' => '<svg viewBox="0 0 60 25" xmlns="http://www.w3.org/2000/svg" class="w-full h-full object-contain"><path fill="#635bff" d="M59.64 14.28h-8.06c.19 1.93 1.6 2.55 3.2 2.55 1.64 0 2.96-.37 4.05-.95v3.32a8.33 8.33 0 0 1-4.56 1.1c-4.01 0-6.83-2.5-6.83-7.48 0-4.19 2.39-7.52 6.3-7.52 3.92 0 5.96 3.28 5.96 7.5 0 .4-.04 1.26-.06 1.48zm-5.92-5.62c-1.03 0-2.17.73-2.17 2.58h4.25c0-1.85-1.07-2.58-2.08-2.58zM40.95 20.3c-1.44 0-2.32-.6-2.9-1.04l-.02 4.63-4.12.87V5.57h3.76l.08 1.02a4.7 4.7 0 0 1 3.23-1.29c2.9 0 5.62 2.6 5.62 7.4 0 5.23-2.7 7.6-5.65 7.6zM40 8.95c-.95 0-1.54.34-1.97.81l.02 6.12c.4.44.98.78 1.95.78 1.52 0 2.54-1.65 2.54-3.87 0-2.15-1.04-3.84-2.54-3.84zM28.24 5.57h4.13v14.44h-4.13V5.57zm0-4.7L32.37 0v3.36l-4.13.88V.88zm-4.32 9.35v9.79H19.8V5.57h3.7l.12 1.22c1-1.77 3.07-1.41 3.62-1.22v3.79c-.52-.17-2.29-.43-3.32.86zm-8.55 4.72c0 2.43 2.6 1.68 3.12 1.46v3.36c-.55.3-1.54.54-2.89.54a4.15 4.15 0 0 1-4.27-4.24l.01-13.17 4.02-.86v3.54h3.14V9.1h-3.13v5.85zm-4.91.7c0 2.97-2.31 4.66-5.73 4.66a11.2 11.2 0 0 1-4.46-.93v-3.93c1.38.75 3.1 1.31 4.46 1.31.92 0 1.53-.24 1.53-1C6.26 13.77 0 14.51 0 9.95 0 7.04 2.28 5.3 5.62 5.3c1.36 0 2.72.2 4.09.75v3.88a9.23 9.23 0 0 0-4.1-1.06c-.86 0-1.44.25-1.44.9 0 1.85 6.29.97 6.29 5.88z" fill-rule="evenodd"></path></svg>',
        'gkash' => 'https://gkash.com/wp-content/uploads/2021/08/Gkash-Logo-256-x-64.png',
    ];

    /**
     * Contructor
     * 
     * @return void
     */
    public function __construct(
        $name = null,
        $size = null,
        $small = false,
    ) {
        $this->name = $name;
        $this->size = $size ? str($size)->replace('px', '')->toString() : null;
        $this->small = $small;
        $this->src = $this->getSrc(); 
    }

    /**
     * Get src
     */
    public function getSrc()
    {
        $filename = $this->name ?? ($this->small ? 'logo-sm' : 'logo');
        
        $src = collect(['svg', 'png', 'jpg', 'jpeg'])->map(function($ext) use ($filename) {
            if (str($filename)->startsWith('logo')) {
                if (file_exists(storage_path("app/public/img/$filename.$ext"))) {
                    return asset("storage/img/$filename.$ext");
                }
            }
            else if (file_exists(storage_path("app/public/img/logo-$filename.$ext"))) {
                return asset("storage/img/logo-$filename.$ext");
            }
            else if (file_exists(storage_path("app/public/app/logo/$filename.$ext"))) {
                return asset("storage/img/logo/$filename.$ext");
            }
            else return null;
        })->filter()->first();
        
        return $src
            ?? $this->sources[$this->name] 
            ?? $this->sources[$this->small ? 'atom-sm' : 'atom']
            ?? null;
    }

    /**
     * Render component
     * 
     * @return Response
     */
    public function render()
    {
        return view('atom::components.logo');
    }
}