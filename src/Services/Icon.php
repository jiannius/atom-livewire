<?php

namespace Jiannius\Atom\Services;

class Icon
{
    public const ICONS = [
        'asterisk' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.9998 3L12.9996 10.267L19.294 6.63397L20.294 8.36602L14.0006 11.999L20.294 15.634L19.294 17.366L12.9996 13.732L12.9998 21H10.9998L10.9996 13.732L4.70557 17.366L3.70557 15.634L9.99857 12L3.70557 8.36602L4.70557 6.63397L10.9996 10.267L10.9998 3H12.9998Z"></path></svg>',
        'at' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C13.6418 20 15.1681 19.5054 16.4381 18.6571L17.5476 20.3214C15.9602 21.3818 14.0523 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12V13.5C22 15.433 20.433 17 18.5 17C17.2958 17 16.2336 16.3918 15.6038 15.4659C14.6942 16.4115 13.4158 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C13.1258 7 14.1647 7.37209 15.0005 8H17V13.5C17 14.3284 17.6716 15 18.5 15C19.3284 15 20 14.3284 20 13.5V12ZM12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9Z"></path></svg>',
        'archive' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20 3L22 7V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V7.00353L4 3H20ZM20 9H4V19H20V9ZM13 10V14H16L12 18L8 14H11V10H13ZM18.7639 5H5.23656L4.23744 7H19.7639L18.7639 5Z"></path></svg>',
        'arrow-left' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"></path></svg>',
        'attach' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M14.8287 7.75737L9.1718 13.4142C8.78127 13.8047 8.78127 14.4379 9.1718 14.8284C9.56232 15.219 10.1955 15.219 10.586 14.8284L16.2429 9.17158C17.4144 8.00001 17.4144 6.10052 16.2429 4.92894C15.0713 3.75737 13.1718 3.75737 12.0002 4.92894L6.34337 10.5858C4.39075 12.5384 4.39075 15.7042 6.34337 17.6569C8.29599 19.6095 11.4618 19.6095 13.4144 17.6569L19.0713 12L20.4855 13.4142L14.8287 19.0711C12.095 21.8047 7.66283 21.8047 4.92916 19.0711C2.19549 16.3374 2.19549 11.9053 4.92916 9.17158L10.586 3.51473C12.5386 1.56211 15.7045 1.56211 17.6571 3.51473C19.6097 5.46735 19.6097 8.63317 17.6571 10.5858L12.0002 16.2427C10.8287 17.4142 8.92916 17.4142 7.75759 16.2427C6.58601 15.0711 6.58601 13.1716 7.75759 12L13.4144 6.34316L14.8287 7.75737Z"></path></svg>',
        'bold' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M8 11H12.5C13.8807 11 15 9.88071 15 8.5C15 7.11929 13.8807 6 12.5 6H8V11ZM18 15.5C18 17.9853 15.9853 20 13.5 20H6V4H12.5C14.9853 4 17 6.01472 17 8.5C17 9.70431 16.5269 10.7981 15.7564 11.6058C17.0979 12.3847 18 13.837 18 15.5ZM8 13V18H13.5C14.8807 18 16 16.8807 16 15.5C16 14.1193 14.8807 13 13.5 13H8Z"></path></svg>',
        'chat-unread' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21 7C22.6569 7 24 5.65685 24 4C24 2.34315 22.6569 1 21 1C19.3431 1 18 2.34315 18 4C18 5.65685 19.3431 7 21 7ZM22 18V8.89998C21.6769 8.96557 21.3425 9 21 9C20.6575 9 20.3231 8.96557 20 8.89998V17H5.76282L4 18.3851V5H16.1C16.0344 4.67689 16 4.34247 16 4C16 3.65753 16.0344 3.32311 16.1 3H3C2.44772 3 2 3.44772 2 4V22.5L6.45455 19H21C21.5523 19 22 18.5523 22 18Z"></path></svg>',
        'check' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path></svg>',
        'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>',
        'close' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path></svg>',
        'close-circle' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z"></path></svg>',
        'double-check' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.602 13.7599L13.014 15.1719L21.4795 6.7063L22.8938 8.12051L13.014 18.0003L6.65 11.6363L8.06421 10.2221L10.189 12.3469L11.6025 13.7594L11.602 13.7599ZM11.6037 10.9322L16.5563 5.97949L17.9666 7.38977L13.014 12.3424L11.6037 10.9322ZM8.77698 16.5873L7.36396 18.0003L1 11.6363L2.41421 10.2221L3.82723 11.6352L3.82604 11.6363L8.77698 16.5873Z"></path></svg>',
        'down' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z"></path></svg>',
        'empty' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4.02381 3.78307C4.12549 3.32553 4.5313 3 5 3H19C19.4687 3 19.8745 3.32553 19.9762 3.78307L21.9762 12.7831C21.992 12.8543 22 12.927 22 13V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V13C2 12.927 2.00799 12.8543 2.02381 12.7831L4.02381 3.78307ZM5.80217 5L4.24662 12H9C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12H19.7534L18.1978 5H5.80217ZM16.584 14C15.8124 15.7659 14.0503 17 12 17C9.94968 17 8.1876 15.7659 7.41604 14H4V19H20V14H16.584Z"></path></svg>',
        'info' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z"></path></svg>',
        'left' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path></svg>',
        'dashboard' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM4 5V19H20V5H4ZM7 13H9V17H7V13ZM11 7H13V17H11V7ZM15 10H17V17H15V10Z"></path></svg>',
        'delete' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M7 4V2H17V4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7ZM6 6V20H18V6H6ZM9 9H11V17H9V9ZM13 9H15V17H13V9Z"></path></svg>',
        'download' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 19H21V21H3V19ZM13 13.1716L19.0711 7.1005L20.4853 8.51472L12 17L3.51472 8.51472L4.92893 7.1005L11 13.1716V2H13V13.1716Z"></path></svg>',
        'dropdown' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#888" style="width: 14px; height: 20px" aria-hidden="true"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path></svg>',
        'file' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M9 2.00318V2H19.9978C20.5513 2 21 2.45531 21 2.9918V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5501 3 20.9932V8L9 2.00318ZM5.82918 8H9V4.83086L5.82918 8ZM11 4V9C11 9.55228 10.5523 10 10 10H5V20H19V4H11Z"></path></svg>',
        'italic' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M15 20H7V18H9.92661L12.0425 6H9V4H17V6H14.0734L11.9575 18H15V20Z"></path></svg>',
        'kanban' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M2 4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4ZM16 19H20V5H16V19ZM14 5H10V19H14V5ZM4 5V19H8V5H4Z"></path></svg>',
        'line-break' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M19.0001 13.9999L19.0002 5L17.0002 4.99997L17.0001 11.9999L6.8283 12L10.778 8.05024L9.36381 6.63603L2.99985 13L9.36381 19.364L10.778 17.9497L6.82825 14L19.0001 13.9999Z"></path></svg>',
        'loading' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="animate-spin"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>',
        'notification' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M5 18H19V11.0314C19 7.14806 15.866 4 12 4C8.13401 4 5 7.14806 5 11.0314V18ZM12 2C16.9706 2 21 6.04348 21 11.0314V20H3V11.0314C3 6.04348 7.02944 2 12 2ZM9.5 21H14.5C14.5 22.3807 13.3807 23.5 12 23.5C10.6193 23.5 9.5 22.3807 9.5 21Z"></path></svg>',
        'ordered-list' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M8 4H21V6H8V4ZM5 3V6H6V7H3V6H4V4H3V3H5ZM3 14V11.5H5V11H3V10H6V12.5H4V13H6V14H3ZM5 19.5H3V18.5H5V18H3V17H6V21H3V20H5V19.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"></path></svg>',
        'pushpin' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13.8273 1.69L22.3126 10.1753L20.8984 11.5895L20.1913 10.8824L15.9486 15.125L15.2415 18.6606L13.8273 20.0748L9.58466 15.8321L4.63492 20.7819L3.2207 19.3677L8.17045 14.4179L3.92781 10.1753L5.34202 8.76107L8.87756 8.05396L13.1202 3.81132L12.4131 3.10422L13.8273 1.69ZM14.5344 5.22554L9.86358 9.89637L7.0417 10.4607L13.5418 16.9609L14.1062 14.139L18.7771 9.46818L14.5344 5.22554Z"></path></svg>',
        'right' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"></path></svg>',
        'setting' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1ZM12 3.311L4.5 7.65311V16.3469L12 20.689L19.5 16.3469V7.65311L12 3.311ZM12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12C16 14.2091 14.2091 16 12 16ZM12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z"></path></svg>',
        'survey' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17 2V4H20.0066C20.5552 4 21 4.44495 21 4.9934V21.0066C21 21.5552 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5551 3 21.0066V4.9934C3 4.44476 3.44495 4 3.9934 4H7V2H17ZM7 6H5V20H19V6H17V8H7V6ZM9 16V18H7V16H9ZM9 13V15H7V13H9ZM9 10V12H7V10H9ZM15 4H9V6H15V4Z"></path></svg>',
        'strikethrough' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17.1538 14C17.3846 14.5161 17.5 15.0893 17.5 15.7196C17.5 17.0625 16.9762 18.1116 15.9286 18.867C14.8809 19.6223 13.4335 20 11.5862 20C9.94674 20 8.32335 19.6185 6.71592 18.8555V16.6009C8.23538 17.4783 9.7908 17.917 11.3822 17.917C13.9333 17.917 15.2128 17.1846 15.2208 15.7196C15.2208 15.0939 15.0049 14.5598 14.5731 14.1173C14.5339 14.0772 14.4939 14.0381 14.4531 14H3V12H21V14H17.1538ZM13.076 11H7.62908C7.4566 10.8433 7.29616 10.6692 7.14776 10.4778C6.71592 9.92084 6.5 9.24559 6.5 8.45207C6.5 7.21602 6.96583 6.165 7.89749 5.299C8.82916 4.43299 10.2706 4 12.2219 4C13.6934 4 15.1009 4.32808 16.4444 4.98426V7.13591C15.2448 6.44921 13.9293 6.10587 12.4978 6.10587C10.0187 6.10587 8.77917 6.88793 8.77917 8.45207C8.77917 8.87172 8.99709 9.23796 9.43293 9.55079C9.86878 9.86362 10.4066 10.1135 11.0463 10.3004C11.6665 10.4816 12.3431 10.7148 13.076 11H13.076Z"></path></svg>',
        'thumb-up' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M14.5998 8.00033H21C22.1046 8.00033 23 8.89576 23 10.0003V12.1047C23 12.3659 22.9488 12.6246 22.8494 12.8662L19.755 20.3811C19.6007 20.7558 19.2355 21.0003 18.8303 21.0003H2C1.44772 21.0003 1 20.5526 1 20.0003V10.0003C1 9.44804 1.44772 9.00033 2 9.00033H5.48184C5.80677 9.00033 6.11143 8.84246 6.29881 8.57701L11.7522 0.851355C11.8947 0.649486 12.1633 0.581978 12.3843 0.692483L14.1984 1.59951C15.25 2.12534 15.7931 3.31292 15.5031 4.45235L14.5998 8.00033ZM7 10.5878V19.0003H18.1606L21 12.1047V10.0003H14.5998C13.2951 10.0003 12.3398 8.77128 12.6616 7.50691L13.5649 3.95894C13.6229 3.73105 13.5143 3.49353 13.3039 3.38837L12.6428 3.0578L7.93275 9.73038C7.68285 10.0844 7.36341 10.3746 7 10.5878ZM5 11.0003H3V19.0003H5V11.0003Z"></path></svg>',
        'unarchive' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20 3L22 7V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V7.00353L4 3H20ZM20 9H4V19H20V9ZM12 10L16 14H13V18H11V14H8L12 10ZM18.764 5H5.236L4.237 7H19.764L18.764 5Z"></path></svg>',
        'underline' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M8 3V12C8 14.2091 9.79086 16 12 16C14.2091 16 16 14.2091 16 12V3H18V12C18 15.3137 15.3137 18 12 18C8.68629 18 6 15.3137 6 12V3H8ZM4 20H20V22H4V20Z"></path></svg>',
        'unordered-list' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M8 4H21V6H8V4ZM4.5 6.5C3.67157 6.5 3 5.82843 3 5C3 4.17157 3.67157 3.5 4.5 3.5C5.32843 3.5 6 4.17157 6 5C6 5.82843 5.32843 6.5 4.5 6.5ZM4.5 13.5C3.67157 13.5 3 12.8284 3 12C3 11.1716 3.67157 10.5 4.5 10.5C5.32843 10.5 6 11.1716 6 12C6 12.8284 5.32843 13.5 4.5 13.5ZM4.5 20.4C3.67157 20.4 3 19.7284 3 18.9C3 18.0716 3.67157 17.4 4.5 17.4C5.32843 17.4 6 18.0716 6 18.9C6 19.7284 5.32843 20.4 4.5 20.4ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"></path></svg>',
        'upload' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 19H21V21H3V19ZM13 5.82843V17H11V5.82843L4.92893 11.8995L3.51472 10.4853L12 2L20.4853 10.4853L19.0711 11.8995L13 5.82843Z"></path></svg>',
        'warning' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>',
    ];

    public const ALIAS = [
        'accounts' => 'address-book',
        'add' => 'plus',
        'address' => 'location-dot',
        'analytics' => 'chart-simple',
        'article' => 'feather-pointed',
        'assign' => 'plus',
        'attachment' => 'paperclip',
        'back' => 'arrow-left',
        'billing' => 'credit-card',
        'block' => 'ban',
        'blog' => 'feather-pointed',
        'buy' => 'bag-shopping',
        'cancel' => 'ban',
        'client' => 'address-book',
        'company' => 'building',
        'config' => 'gear',
        'contacts' => 'address-book',
        'create' => 'plus',
        'deselect-all' => 'xmark',
        'duplicate' => 'copy',
        'edit' => 'pen-to-square',
        'email' => 'envelope',
        'enquiries' => 'clipboard-question',
        'enquiry' => 'clipboard-question',
        'excel' => 'file-excel',
        'export' => 'file-export',
        'facebook' => 'brands facebook',
        'finance' => 'magnifying-glass-dollar',
        'financial' => 'magnifying-glass-dollar',
        'google' => 'brands google',
        'help' => 'life-ring',
        'hide' => 'eye-slash',
        'import' => 'cloud-arrow-up',
        'invitation' => 'envelope-circle-check',
        'invoice' => 'file-invoice-dollar',
        'linkedin' => 'brands linkedin',
        'location' => 'location-dot',
        'login' => 'arrow-right-to-bracket',
        'logout' => 'arrow-right-from-bracket',
        'new' => 'plus',
        'open' => 'arrow-up-right-from-square',
        'powerpoint' => 'file-powerpoint',
        'ppt' => 'file-powerpoint',
        'preference' => 'screwdriver-wrench',
        'preview' => 'eye',
        'product' => 'cube',
        'project' => 'survey',
        'publish' => 'cloud-arrow-up',
        'purchase' => 'bag-shopping',
        'quotation' =>  'file-circle-question',
        'refresh' => 'arrows-rotate',
        'remove' => 'circle-minus',
        'report' => 'magnifying-glass-chart',
        'restore' => 'trash-arrow-up',
        'sales' => 'sack-dollar',
        'save' => 'check',
        'search' => 'magnifying-glass',
        'select-all' => 'check-double',
        'send' => 'paper-plane',
        'seo' => 'searchengin',
        'share' => 'share-nodes',
        'show' => 'eye',
        'signup' => 'user-plus',
        'split' => 'arrows-split-up-and-left',
        'stop' => 'ban',
        'submit' => 'check',
        'support' => 'life-ring',
        'telegram' => 'brands telegram',
        'tenant' => 'house-user',
        'transaction' => 'arrow-right-arrow-left',
        'trash' => 'trash-can',
        'unblock' => 'play',
        'undo' => 'arrow-rotate-left',
        'unpublish' => 'arrow-rotate-left',
        'update' => 'pen-to-square',
        'vendor' => 'people-carry-box',
        'whatsapp' => 'brands whatsapp',
        'word' => 'file-word',    
    ];

    // get icon
    public static function get($name)
    {
        if (!$name) return '';

        $name = get(self::ALIAS, $name) ?? $name;
        $icon = get(self::ICONS, $name) ?? '';
        $isImg = str($icon)->startsWith('data:image/');

        if ($isImg) return '<img src="'.$icon.'" class="w-full h-full object-contain">';
        else if ($icon) return $icon;


        $fa = collect(explode(' ', $name))
            ->map(fn($value) => (string) str($value)->start('fa-'))
            ->prepend('fa-solid')
            ->join(' ');

        return '<i class="'.$fa.'"></i>';
    }

    // get js response
    public static function jsResponse()
    {
        \Barryvdh\Debugbar\Facades\Debugbar::disable();

        $icons = self::ICONS;
        $content = \Illuminate\Support\Facades\Blade::render('window.icons = {{ Js::from($icons) }}', ['icons' => $icons]);

        return response($content)->header('Content-Type', 'application/javascript');
    }
}