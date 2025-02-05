import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useLocation, useNavigate } from 'react-router-dom';
import { ScaleLoader } from "react-spinners"; 
import Title from '../components/Common/Title/Title';
import Subtitle from '../components/Common/Subtitle/Subtitle';
import Description from '../components/Common/Description/Description';
import CodeBlock from '../components/CodeBlock/CodeBlock';
import List from '../components/List/List';
import Note from '../components/Note/Note';
import ScreenshotImage from './Screenshot/ScreenshotImage';
import ScreenshotGallery from '../components/Screenshot/ScreenshotGallery';
import HorizontalLine from '../components/Common/HorizontalLine/HorizontalLine';
import Button from '../components/Common/Button/Button';
import NoDataFoundTemplate from './Common/Template/NoDataFoundTemplate';
import Tree from './Tree/Tree';
import CustomLink from './Common/CustomLink/CustomLink';

const ContentSection = ({ topicSlug, currentVersion }) => {
  const [topic, setTopic] = useState(null);
  const [loading, setLoading] = useState(true);
  const [noDataFound, setNoDataFound] = useState(false);
  const navigate = useNavigate();
  const location = useLocation();

  const homePage = {
    title: "Welcome to the official documentation for WisenShop",
    description: "This documentation is designed to provide a comprehensive and professional resource for understanding and utilizing our software to its fullest potential. Please use the navigation menu to explore topics or leverage the search functionality to find specific information.",
    button: {
      text: 'Start Exploring',
      icon: 'far fa-window-maximize'
    }
  };

  useEffect(() => {
    const handleScrollToBlock = () => {
      const pathname = location.pathname;
      const blockId = pathname.split("/").pop();

      if (blockId && !isNaN(blockId)) {
        const element = document.getElementById(blockId);
        if (element) {
          element.scrollIntoView({ block: "nearest", behavior: "smooth" });

          setTimeout(() => {
            element.classList.add("popup-effect");
            setTimeout(() => element.classList.remove("popup-effect"), 1500);
          }, 100);
        } else {
          navigate(`/${topicSlug}`);
          window.scrollTo({ top: 0, behavior: "smooth" });
        }
      } else {
        navigate(`/${topicSlug}`);
        window.scrollTo({ top: 0, behavior: "smooth" });
      }
    };

    if (topic) {
      const timeoutId = setTimeout(() => handleScrollToBlock(), 500);
      return () => clearTimeout(timeoutId);
    }
  }, [location.pathname, topic, navigate, topicSlug]);

  useEffect(() => {
    if (topicSlug && topicSlug !== 'undefined' && currentVersion) {
      fetchTopicBlocks(topicSlug, currentVersion);
    } else {
      setLoading(false);
    }
  }, [topicSlug, currentVersion]);

  const fetchTopicBlocks = async (slug, version) => {
    setLoading(true);
    setNoDataFound(false);
    try {
      const response = await axios.get(`/api/version/${version}/topics/${slug}`);
      setTopic(response.data);
    } catch (error) {
      if (error.response && error.response.status === 404) {
        setNoDataFound(true);
      } else {
        console.error('Error fetching topic blocks:', error);
      }
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="loader-container fixed inset-0 bg-gray-800 bg-opacity-70 flex justify-center items-center z-20">
        <ScaleLoader color="#3d5f8a" loading margin={4} radius={26} speedMultiplier={2} />
      </div>
    );
  }

  if (topicSlug && topicSlug === 'undefined') {
    navigate('/');
    return null;
  }

  if (!topicSlug) {
    return (
      <main className="flex-1 p-6 main-content">
        <div className="bg-theme-light dark:bg-theme-dark rounded-xl shadow-lg p-8 md:p-6 sm:p-4 right-side-content">
          <Title text={homePage?.title} level="h2" classNames="text-xl font-semibold text-gray-600 dark:text-theme-darkText mb-3" />
          <HorizontalLine height="1px" color="#dedede" opacity={0.2} margin="10px 0" />
          <Description content={homePage?.description} classNames="text-sm font-semibold text-gray-400" />
          <Button
            text={homePage.button.text}
            onClick={() => document.querySelector(".sidebar-menu-item")?.click()}
            size="small"
            classNames="mt-4"
            color="themeLight"
            icon={homePage.button.icon}
          />
        </div>
      </main>
    );
  }

  if (!topic) {
    return <p className="text-gray-400"></p>;
  }

  if (!topic.hasOwnProperty('blocks') || noDataFound) {
    return (
      <NoDataFoundTemplate
        heading={`No results found for <strong>#${topicSlug}</strong>`}
        description={`<span class="text-muted">[Version ${currentVersion}]</span>`}
        icon="fa fa-hourglass-start"
      />
    );
  }

  return (
    <main className="flex-1 p-6 md:p-4 sm:p-3 main-content">
      <div className="bg-theme-light dark:bg-theme-dark rounded-xl shadow-lg p-8 md:p-6 sm:p-4 right-side-content">
        <h2 className="text-3xl md:text-2xl sm:text-xl font-bold text-theme-dark dark:text-theme-light mb-4">
          {topic.name}
        </h2>
        {topic.blocks.map((block) => {
          let parsedAttributes = {};
          try {
            parsedAttributes = JSON.parse(block.attributes) || {};
          } catch (error) {
            console.error('Failed to parse block.attributes:', error);
          }

          const paddingLeft =
            block.start_content_level === 1 ? '0%' :
            block.start_content_level === 2 ? '2%' : '5%';

          return (
            <div
              key={block.id}
              id={`${block.id}`}
              style={{ paddingLeft }}
              className="mb-6 sm:mb-4"
            >
              {block.block_type.type === 'title' && (
                <Title text={parsedAttributes?.text} level={parsedAttributes?.level || 'h2'} classNames={parsedAttributes?.classes || 'text-xl font-semibold text-gray-900 dark:text-gray-200 mb-4'} />
              )}
              {block.block_type.type === 'subtitle' && (
                <Subtitle text={parsedAttributes?.text} classNames={parsedAttributes?.classes || 'text-md font-semibold text-gray-900 dark:text-gray-200 mb-4'} />
              )}
              {block.block_type.type === 'description' && (
                <Description content={parsedAttributes?.text} classNames={parsedAttributes?.classes || 'text-theme-dark dark:text-theme-light leading-relaxed mb-4'} />
              )}
              {block.block_type.type === 'code_block' && (
                <CodeBlock
                  title={parsedAttributes?.title}
                  description={parsedAttributes?.description}
                  buttonText={parsedAttributes?.copy_btn_text}
                  copyContent={parsedAttributes?.copy_content}
                />
              )}
              {block.block_type.type === 'note' && (
                <Note
                  type={parsedAttributes?.type}
                  title={parsedAttributes?.title}
                  icon={parsedAttributes?.icon}
                  text={parsedAttributes?.text}
                />
              )}
              {block.block_type.type === 'list' && (
                <List items={parsedAttributes?.list || []} />
              )}
              {block.block_type.type === 'screenshot' && (
                <ScreenshotImage
                  title={parsedAttributes?.title}
                  description={parsedAttributes?.description}
                  imageUrl={parsedAttributes?.imageUrl}
                />
              )}
              {block.block_type.type === 'screenshot-gallery' && (
                <ScreenshotGallery images={parsedAttributes?.images || []} />
              )}
              {block.block_type.type === 'tree' && (
                <Tree nodes={parsedAttributes?.nodes || []} />
              )}
              {block.block_type.type === 'custom-link' && (
                <CustomLink attributes={parsedAttributes || []} />
              )}
            </div>
          );
        })}
      </div>
    </main>
  );
};

export default ContentSection;