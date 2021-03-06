<?php
/**
 * GCalendar is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GCalendar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GCalendar.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Allon Moritz
 * @copyright 2007-2011 Allon Moritz
 * @since 2.2.0
 */

defined('_JEXEC') or die('Restricted access');
?>
<a href="http://www.google.com/calendar" target="_blank"><b>Go to google calendar administration site!!</b></a><hr/>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( 'ID' ); ?></th>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
			<th><?php echo JText::_( 'CALENDAR_NAME' ); ?></th>
			<th><?php echo JText::_( 'CALENDAR_COLOR' ); ?></th>
			<th align="left"><?php echo JText::_( 'CALENDAR_DETAILS' ); ?></th>
		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_gcalendar&task=gcalendar.edit&id='. $row->id );

		?>
	<tr class="<?php echo "row$k"; ?>">
		<td><?php echo $row->id; ?></td>
		<td><?php echo $checked; ?></td>
		<td><a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></td>
		<td width="40px"><div style="background-color: <?php echo GCalendarUtil::getFadedColor($row->color);?>;width: 100%;height: 100%;"></div></td>
		<td>
		<table>
			<tr>
				<td><b><?php echo JText::_( 'Calendar ID' ); ?>:</b></td>
				<td><?php echo $row->calendar_id; ?></td>
			</tr>
			<tr>
				<td><b><?php echo JText::_( 'Magic Cookie' ); ?>:</b></td>
				<td><?php echo $row->magic_cookie; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<?php
	$k = 1 - $k;
	}
	?>
	<tfoot>
		<tr>
			<td colspan="5"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>

</table>
</div>
<div>
<input type="hidden" name="option" value="com_gcalendar" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" /> 
<?php echo JHtml::_('form.token'); ?>
</div>
</form>

<div align="center"><br>
<img src="media/com_gcalendar/images/gcalendar.gif" width="156"
	height="30"><br>
&copy;&nbsp;&nbsp;2011 <a href="http://g4j.laoneo.net"
	target="_blank">allon moritz</a></div>
