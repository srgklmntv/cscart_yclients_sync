{script src="js/tygh/tabs.js"}

{capture name="mainbox"}
    {include file="common/pagination.tpl"}
        <form action="{""|fn_url}" method="post" name="yclients_sync_bookings_form" id="yclients_sync_bookings_form">
            <input type="hidden" name="return_url" value="{$config.current_url}">

            {capture name="yclients_sync_bookings_table"}
                <div class="items-container" id="yclients_sync_bookings_list">
                    {if $bookings}
                        <div class="table-responsive-wrapper" data-ca-sortable-table="yclients_sync_bookings" data-ca-sortable-id-name="map_id">
                            <table class="table table-middle table--relative table-responsive">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{__("yclients_sync.staff")}</th>
                                <th>{__("yclients_sync.client")}</th>
                                <th>{__("yclients_sync.visit_date")}</th>
                            </tr>
                            </thead>
                            <tbody class="hover">
                            {foreach from=$bookings item="booking" name="bookings"}
                                <tr class="hover cm-longtap-target cm-row-item" data-ca-id="{$booking.booking_id}">
                                    <td data-th="&nbsp;">
                                        <input type="checkbox" name="booking_ids[]" value="{$booking.booking_id}" class="cm-item hide" />
                                    </td>
                                    <td data-th="{__("person_name")}" class="control-group">
                                        <div>
                                            {$booking.data.staff.name}
                                        </div>
                                        <div class="muted">{$booking.data.staff.specialization}</div>
                                    </td>
                                    <td data-th="{__("person_name")}" class="control-group">
                                        <a href="{"profiles.update?user_id=`$booking.user_id`&user_type=`$booking.user_type`"|fn_url}">
                                            <div>{$booking.lastname} {$booking.firstname}</div>
                                        </a>
                                        <a href="tel:{$booking.phone}"><bdi>{$booking.phone}</bdi></a>
                                    </td>
                                    <td data-th="{__("phone")}" class="control-group">
                                        {$booking.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                            </table>
                        </div>
                    {else}
                        <p class="no-items">{__("no_data")}</p>
                    {/if}
                <!--yclients_sync_bookings_list--></div>
            {/capture}

            {include file="common/context_menu_wrapper.tpl"
                form="yclients_sync_bookings_form"
                object="yclients_sync_bookings"
                items=$smarty.capture.yclients_sync_bookings_table
            }
        </form>
    {include file="common/pagination.tpl"}
{/capture}

{capture name="adv_buttons"}
    {hook name="orders:manage_tools"}
        {include file="common/tools.tpl"
            tool_href="order_management.new"
            tool_override_meta="btn btn-primary nav__actions-btn-primary"
            prefix="bottom"
            hide_tools="true"
            title=__("add_order")
            link_text=__("add_order")
            icon="icon-plus"
        }
    {/hook}
{/capture}

{capture name="buttons"}
    {include file="buttons/button.tpl" but_text=__("yclients_sync.sync") but_meta="cm-ajax cm-ajax-full-render" but_role="submit-link" but_href="yclients_sync.bookings.sync" but_target_id="yclients_sync_bookings_list"}
{/capture}

{include
    file="common/mainbox.tpl"
    title=__("yclients_sync.bookings")
    content=$smarty.capture.mainbox
    buttons=$smarty.capture.buttons
}