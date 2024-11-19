<?php
class OpeningHoursCard {
    public static function render($openingHour) {
			$openingHourData = json_encode([
				'id' => $openingHour->getOpeningHourId(),
				'day' => $openingHour->getDay(),
				'openingTime' => $openingHour->getOpeningTime()->format('H:i'),
				'closingTime' => $openingHour->getClosingTime()->format('H:i'),
				'isCurrent' => $openingHour->getIsCurrent()
			]);
			
      echo "
				<div class='bg-bgSemiDark border-[1px] border-borderDark rounded p-4'>
					<div class='flex justify-between items-center'>
						<h4 class='text-[1.25rem] font-semibold'>" . htmlspecialchars($openingHour->getDay()) . "</h4>
						<div>";
						if ($openingHour->getIsCurrent()) {
							echo "<p class='py-[.125rem] px-2 text-[.75rem] font-medium text-primary border-[1px] border-primary rounded-full'>Current</p>";
						}
						echo "</div>
					</div>
					<p>" . htmlspecialchars($openingHour->getOpeningTime()->format('H:i')) . " - " . htmlspecialchars($openingHour->getClosingTime()->format('H:i')) . "</p>
					<div class='flex justify-start mt-4 gap-[.5rem]'>
						<button onclick=\"openEditOpeningHourModal('" . htmlspecialchars($openingHourData) . "')\" class='py-1 px-2 text-primary border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[.2s] ease-in-out'>
              Edit
            </button>
						<button onclick=\"openDeleteOpeningHourModal('" . htmlspecialchars($openingHour->getOpeningHourId()) . "')\" class='bg-red-500 text-textDark py-1 px-2 border-[1px] border-red-500 rounded hover:bg-red-600 hover:border-red-600'>
								Delete
						</button>
					</div>
				</div>
				";
    }
}