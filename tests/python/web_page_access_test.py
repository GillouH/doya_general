#!./venv/bin/python
# coding: utf-8
"""
This module make some test for the doya project website.

fnjirep
"""

import os
import unittest

from selenium.webdriver import Chrome
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.remote.webdriver import WebElement
from pyvirtualdisplay import Display


class WebPageTest(unittest.TestCase):
    """
    This class test the connection to the website.
    """
    PRIVATE_PORT: int = 59224

    PUBLIC_IP: str = "88.160.86.12"
    PUBLIC_PORT: int = 44645

    @classmethod
    def setUpClass(cls):
        # Screen simulator.
        cls.display: Display = Display(
            visible=False,
            size=(800, 600)
        )
        cls.display.start()

        # Chrome driver.
        chromedriver_path: str = os.path.join(
            "/usr",
            "lib",
            "chromium-browser",
            "chromedriver"
        )
        cls.service: Service = Service(
            executable_path=chromedriver_path
        )
        cls.driver: Chrome = Chrome(service=cls.service)

    def web_page_access(self, host: str, port: int):
        """
        This method test the connection to the website.

        :param host: Hostname or IP Address of the website.
        :param port: Connection port of the website.
        """
        # Go to the url.
        self.driver.get(url=f"https://{host}:{port}")

        # If we have the warning google page because of the invalid
        # certificate.
        if self.driver.title == "Privacy error":
            # Search for and click on 'Details' and Continue (unsafe) buttons.
            for button_id in "details-button", "proceed-link":
                self.assertIsInstance(
                    obj=(button := self.driver.find_element(
                        by=By.ID,
                        value=button_id
                    )),
                    cls=WebElement,
                    msg="Couldn't find the button with the id: {id}.".format(
                            id=button_id
                        )
                )
                button.click()

        # Check the title of the web page.
        self.assertEqual(self.driver.title, "Doya General")

        # Check the presence of the form.
        self.assertIsInstance(
            obj=(form := self.driver.find_element(
                by=By.TAG_NAME,
                value="form"
            )),
            cls=WebElement,
            msg="Couldn't find the form."
        )
        # Check the presence of the legend in the form.
        self.assertIsInstance(
            obj=(legend := form.find_element(
                by=By.TAG_NAME,
                value="legend"
            )),
            cls=WebElement,
            msg="Couldn't find the legend in the form."
        )
        # Check the value "Guess a Username and Password !" in the legend.
        self.assertEqual(
            first=legend.text,
            second="Guess a Username and Password !",
            msg="The legend doesn't have the expected text."
        )

    def test_web_page_local_access(self):
        """
        This method test the connection to the website via the local network.
        """
        self.web_page_access(
            host="localhost",
            port=self.PRIVATE_PORT
        )

    def test_web_page_internet_access(self):
        """
        This method test the connection to the website via the internet.
        """
        self.web_page_access(
            host=self.PUBLIC_IP,
            port=self.PUBLIC_PORT
        )

    @classmethod
    def tearDownClass(cls):
        cls.driver.close()
        cls.service.stop()
        cls.display.stop()


if __name__ == "__main__":
    unittest.main()
